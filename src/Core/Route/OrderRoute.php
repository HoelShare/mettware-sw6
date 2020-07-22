<?php declare(strict_types=1);

namespace Mettware\Core\Route;

use Mettware\Core\OrderListLoader;
use Mettware\Core\OrderService;
use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\RequestCriteriaBuilder;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"store-api"})
 */
class OrderRoute
{
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

    /**
     * @var OrderListLoader
     */
    private $orderListLoader;

    public function __construct(
        RequestCriteriaBuilder $requestCriteriaBuilder,
        OrderDefinition $orderDefinition,
        OrderService $orderService,
        OrderListLoader $orderListLoader
    ) {
        $this->requestCriteriaBuilder = $requestCriteriaBuilder;
        $this->orderDefinition = $orderDefinition;
        $this->orderService = $orderService;
        $this->orderListLoader = $orderListLoader;
    }

    /**
     * @Route(path="/store-api/v{version}/mw-order", name="store-api.mettware.order", methods={"GET"})
     */
    public function load(Request $request, SalesChannelContext $context): OrderRouteResponse
    {
        $criteria = new Criteria();
        $criteria = $this->requestCriteriaBuilder->handleRequest(
            $request,
            $criteria,
            $this->orderDefinition,
            $context->getContext()
        );

        $orders = $this->orderListLoader->load($criteria, $context);

        $isStopped = $this->orderService->isStopped($context->getContext());

        return new OrderRouteResponse($orders, $isStopped);
    }

    /**
     * @Route(path="/store-api/v{version}/mw-order", name="store-api.mettware.stop-order", methods={"POST"})
     */
    public function stopOrders(SalesChannelContext $salesChannelContext): StopRouteResponse
    {
        $success = $this->orderService->stopOrders($salesChannelContext->getContext());

        return new StopRouteResponse($success);
    }
}
