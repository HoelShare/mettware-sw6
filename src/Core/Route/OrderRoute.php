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
     * @var OrderService
     */
    private $orderService;

    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService = $orderService;
    }

    /**
     * @Route(path="/store-api/v{version}/mw-order", name="store-api.mettware.stop-order", methods={"POST"})
     */
    public function stopOrders(SalesChannelContext $salesChannelContext): StopRouteResponse
    {
        $success = $this->orderService->stopOrders($salesChannelContext);

        return new StopRouteResponse($success);
    }
}
