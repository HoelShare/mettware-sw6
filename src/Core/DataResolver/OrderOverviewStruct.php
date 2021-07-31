<?php

declare(strict_types=1);

namespace Mettware\Core\DataResolver;

use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\Struct\Struct;

class OrderOverviewStruct extends Struct
{
    private EntitySearchResult $orders;
    private bool $isStopped;

    public function __construct(EntitySearchResult $orders, bool $isStopped)
    {
        $this->orders = $orders;
        $this->isStopped = $isStopped;
    }

    public function getOrders(): EntitySearchResult
    {
        return $this->orders;
    }

    public function isStopped(): bool
    {
        return $this->isStopped;
    }
}
