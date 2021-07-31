<?php
declare(strict_types=1);

namespace Mettware\Core\DataResolver;

use Mettware\Core\Order\MettwareOrderDefinition;
use Mettware\Core\OrderListLoader;
use Mettware\Core\OrderService;
use Mettware\Core\Route\ProductNameStruct;
use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity;
use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Bucket\FilterAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Bucket\TermsAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\SumAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Bucket\TermsResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;

class OrderOverviewCmsElementResolver extends AbstractCmsElementResolver
{
    private OrderListLoader $orderListLoader;
    private OrderService $orderService;

    public function __construct(
        OrderListLoader $orderListLoader,
        OrderService $orderService
    ) {
        $this->orderListLoader = $orderListLoader;
        $this->orderService = $orderService;
    }

    public function getType(): string
    {
        return 'mettware-order-overview';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $orderCriteria = $this->orderListLoader->buildCriteria();
        $mettwareOrder = $this->orderService->buildStopOrderCriteria();
        $criteriaCollection = new CriteriaCollection();
        $criteriaCollection->add('order_' . $slot->getUniqueIdentifier(), OrderDefinition::class, $orderCriteria);
        $criteriaCollection->add('mettware_order', MettwareOrderDefinition::class, $mettwareOrder);

        return $criteriaCollection;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        /** @var EntitySearchResult $orders */
        $orders = $result->get('order_' . $slot->getUniqueIdentifier());
        if (!$orders) {
            return;
        }
        $mettwareOrder = $result->get('mettware_order');
        $isStopped = !($mettwareOrder === null || $mettwareOrder->count() === 0);

        $orders = $this->orderListLoader->enhanceOrders($orders);

        $slot->setData(new OrderOverviewStruct($orders, $isStopped));
    }
}
