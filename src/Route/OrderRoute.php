<?php declare(strict_types=1);

namespace Mettware\Route;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Mettware\Core\OrderService;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\FilterAggregation;
use Shopware\B2B\Statistic\Framework\StatisticAggregate;
use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Bucket\TermsAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\CountAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\MaxAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\StatsAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\SumAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"store-api"})
 */
class OrderRoute
{
    /**
     * @var EntityRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var RequestCriteriaBuilder
     */
    private $requestCriteriaBuilder;

    /**
     * @var OrderDefinition
     */
    private $orderDefinition;

    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(
        EntityRepositoryInterface $orderRepository,
        RequestCriteriaBuilder $requestCriteriaBuilder,
        OrderDefinition $orderDefinition,
        OrderService $orderService
    ) {
        $this->orderRepository = $orderRepository;
        $this->requestCriteriaBuilder = $requestCriteriaBuilder;
        $this->orderDefinition = $orderDefinition;
        $this->orderService = $orderService;
    }

    /**
     * @Route(path="/store-api/v{version}/mw-order", name="store-api.mettware.order", methods={"GET"})
     */
    public function load(Request $request, SalesChannelContext $context)
    {
        $criteria = new Criteria();
        $criteria = $this->requestCriteriaBuilder->handleRequest(
            $request,
            $criteria,
            $this->orderDefinition,
            $context->getContext()
        );

        $startOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0);
        $endOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0)->add(new \DateInterval('P1D'));

        $criteria->addFilter(new RangeFilter('createdAt', [
            RangeFilter::GTE => $startOfDay->format('Y-m-d H:i:s'),
            RangeFilter::LTE => $endOfDay->format('Y-m-d H:i:s'),
        ]));
        $criteria->addAssociation('lineItems.product');
        $criteria->addAssociation('customer');

        $criteria->addAggregation(new TermsAggregation('count', 'order.lineItems.product.name', null, new FieldSorting('order.lineItems.product.name'), new SumAggregation('quantity', 'order.lineItems.quantity')));
        $criteria->addAggregation(new SumAggregation('sum', 'amountNet'));
        $criteria->addAggregation(new SumAggregation('total-count', 'order.lineItems.quantity'));

        $criteria->addSorting(new FieldSorting('orderNumber'));

        $orders = $this->orderRepository->search($criteria, $context->getContext());

        $isStopped = $this->orderService->isStopped($context->getContext());

        return new OrderRouteResponse($orders, $isStopped);
    }

    /**
     * @Route(path="/store-api/v{version}/mw-order", name="store-api.mettware.stop-order", methods={"POST"})
     */
    public function stopOrders(SalesChannelContext $salesChannelContext)
    {
        $success = $this->orderService->stopOrders($salesChannelContext->getContext());

        return new StopRouteResponse($success);
    }
}
