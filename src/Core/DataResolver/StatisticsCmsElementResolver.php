<?php declare(strict_types=1);

namespace Mettware\Core\DataResolver;

use Mettware\Core\Statistics\StatisticsCollection;
use Mettware\Core\Statistics\CustomerStatistics;
use Mettware\Core\Statistics\StatisticsLoader;
use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Bucket\TermsResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Metric\SumResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class StatisticsCmsElementResolver extends AbstractCmsElementResolver
{
    private const CRITERIA_KEY = 'mettware_statistics';

    private StatisticsLoader $statisticsLoader;
    private SystemConfigService $systemConfigService;

    public function __construct(
        StatisticsLoader $statisticsLoader,
        SystemConfigService $systemConfigService
    ) {
        $this->statisticsLoader = $statisticsLoader;
        $this->systemConfigService = $systemConfigService;
    }

    public function getType(): string
    {
        return 'mettware-statistics';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $criteria = $this->statisticsLoader->buildCriteria();

        $criteriaCollection = new CriteriaCollection();
        $criteriaCollection->add(self::CRITERIA_KEY, OrderDefinition::class, $criteria);

        return $criteriaCollection;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $orders = $result->get(self::CRITERIA_KEY);

        if (!$orders) {
            return;
        }

        /** @var TermsResult $countResult */
        $countResult = $orders->getAggregations()->get('customerNumber');
        $customerCollection = new StatisticsCollection();
        foreach ($countResult->getKeys() as $customerNumber) {
            $customer = new CustomerStatistics();
            $customer->setCustomerNumber($customerNumber);

            $customerCollection->add($customer);

            /** @var TermsResult $meatContents */
            $meatContents = $countResult->get($customerNumber)->getResult();

            foreach ($meatContents->getKeys() as $meatContent) {
                $content = (float) $meatContent;
                /** @var SumResult $quantity */
                $quantity = $meatContents->get($meatContent)->getResult();
                $customer->addCount($quantity->getSum());
                $customer->addMeatContent($content * $quantity->getSum());
            }
        }

        foreach ($customerCollection as $customer) {
            $this->enrichCustomer($customer, $orders);
        }

        $customerCollection->sortByMeatContent();
        $customerCollection->setContentPerPig($this->getPigWeight());

        $slot->setData($customerCollection);
    }

    private function getPigWeight(): float
    {
        $pigWeight = $this->systemConfigService->get('Mettware.config.pigWeight');

        return $pigWeight ?? 96000;
    }

    private function enrichCustomer(CustomerStatistics $customer, EntitySearchResult $orders): void
    {
        /** @var OrderEntity $order */
        foreach ($orders as $order) {
            $orderCustomer = $order->getOrderCustomer();
            if (!$orderCustomer || $customer->getCustomerNumber() !== $orderCustomer->getCustomerNumber()) {
                continue;
            }

            $customer->setFirstName($orderCustomer->getFirstName());
            $customer->setLastName($orderCustomer->getLastName());
            return;
        }
    }
}
