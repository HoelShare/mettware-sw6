<?php declare(strict_types=1);

namespace Mettware\Core;

use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\CartValidatorInterface;
use Shopware\Core\Checkout\Cart\Error\ErrorCollection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class CartValidator implements CartValidatorInterface
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function validate(Cart $cart, ErrorCollection $errorCollection, SalesChannelContext $salesChannelContext): void
    {
        if (!$this->orderService->isStopped($salesChannelContext->getContext())) {
            return;
        }

        $errorCollection->add(new OrderStoppedError());
    }
}
