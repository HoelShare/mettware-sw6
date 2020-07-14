<?php declare(strict_types=1);

namespace Mettware\Controller;

use Mettware\Core\OrderService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class OrderApiController extends AbstractController
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @Route("/api/v{version}/_action/mettware/free", name="api.action.mettware.free", methods={"POST"})
     */
    public function freeOrders(Context $context): JsonResponse
    {
        $this->orderService->openOrders($context);

        return new JsonResponse(['ok' => true]);
    }
}
