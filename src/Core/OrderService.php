<?php declare(strict_types=1);

namespace Mettware\Core;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Mettware\Message\StopOrdersMessage;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderService
{
    private EntityRepositoryInterface $mettwareOrderRepository;
    private MessageBusInterface $messageBus;
    private OrderListLoader $orderListLoader;

    public function __construct(
        EntityRepositoryInterface $mettwareOrderRepository,
        MessageBusInterface $messageBus,
        OrderListLoader $orderListLoader
    ) {
        $this->mettwareOrderRepository = $mettwareOrderRepository;
        $this->messageBus = $messageBus;
        $this->orderListLoader = $orderListLoader;
    }

    public function isStopped(Context $context): bool
    {
        return (bool) $this->getTodayOrderId($context);
    }

    public function stopOrders(SalesChannelContext $context): bool
    {
        try {
            $this->mettwareOrderRepository->create([['id' => Uuid::randomHex()]], $context->getContext());
        } catch (UniqueConstraintViolationException $constraintViolationException) {
            return false;
        }

        $this->sendStopOrdersMessage($context);

        return true;
    }

    public function openOrders(Context $context): void
    {
        $id = $this->getTodayOrderId($context);

        if (!$id) {
            return;
        }

        $this->mettwareOrderRepository->delete([['id' => $id]], $context);
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

    private function sendStopOrdersMessage(SalesChannelContext $context): void
    {
        $orders = $this->orderListLoader->load(new Criteria(), $context);

        $this->messageBus->dispatch(new StopOrdersMessage('', $orders));
    }
}
