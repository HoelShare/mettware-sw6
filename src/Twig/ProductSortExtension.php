<?php declare(strict_types=1);

namespace Mettware\Twig;

use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity;
use Twig\Extension\RuntimeExtensionInterface;

class ProductSortExtension implements RuntimeExtensionInterface
{
    public function sort(array $elements): array
    {
        usort($elements, function (OrderLineItemEntity $itemA, OrderLineItemEntity $itemB) {
            if ($itemA->getType() === 'product') {
                return -1;
            }

            return $itemA->getType() <=> $itemA->getType();
        });

        return $elements;
    }
}
