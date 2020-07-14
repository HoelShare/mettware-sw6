<?php declare(strict_types=1);

namespace Mettware\Core;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Mettware\Route\StopRouteResponse;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class OrderService
{
    /**
     * @var EntityRepositoryInterface
     */
    private $mettwareOrderRepository;

    public function __construct(EntityRepositoryInterface $mettwareOrderRepository)
    {
        $this->mettwareOrderRepository = $mettwareOrderRepository;
    }

    public function isStopped(Context $context): bool
    {
        return (bool) $this->getTodayOrderId($context);
    }

    public function stopOrders(Context $context): bool
    {
        try {
            $this->mettwareOrderRepository->create([['id' => Uuid::randomHex()]], $context);
        } catch (UniqueConstraintViolationException $constraintViolationException) {
            return false;
        }

        return true;
    }

    public function openOrders(Context $context): void
    {
        $id = $this->getTodayOrderId($context);

        if (!$id) {
            return;
        }

        $this->mettwareOrderRepository->delete([$id], $context);
    }

    private function getTodayOrderId(Context $context): ?string
    {
        $criteria = new Criteria();
        $startOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0);
        $endOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0)->add(new \DateInterval('P1D'));

        $criteria->addFilter(new RangeFilter('stopDate', [
            RangeFilter::GTE => $startOfDay->format('Y-m-d H:i:s'),
            RangeFilter::LTE => $endOfDay->format('Y-m-d H:i:s'),
        ]));

        return $this->mettwareOrderRepository->searchIds($criteria, $context)->firstId();
    }
}
