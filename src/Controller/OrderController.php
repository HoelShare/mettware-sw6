<?php declare(strict_types=1);

namespace Mettware\Controller;

use Mettware\Core\Route\OrderRoute;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class OrderController extends StorefrontController
{
    /**
     * @var OrderRoute
     */
    private $orderRoute;

    public function __construct(OrderRoute $orderRoute)
    {
        $this->orderRoute = $orderRoute;
    }

    /**
     * @Route(path="/mw-order", name="frontend.mettware.stop-order", methods={"POST"}, defaults={"XmlHttpRequest"=true})
     */
    public function stopOrders(SalesChannelContext $salesChannelContext)
    {
        $stopResponse = $this->orderRoute->stopOrders($salesChannelContext);

        return $this->renderStorefront('@Mettware/storefront/mettware/stop-orders.html.twig', [
            'stop' => $stopResponse->getObject(),
        ]);
    }
}
