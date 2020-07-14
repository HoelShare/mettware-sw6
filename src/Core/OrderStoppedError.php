<?php declare(strict_types=1);

namespace Mettware\Core;

use Shopware\Core\Checkout\Cart\Error\Error;

class OrderStoppedError extends Error
{
    private const KEY = 'mettware-order-stopped';

    public function getId(): string
    {
        return self::KEY;
    }

    public function getMessageKey(): string
    {
        return self::KEY;
    }

    public function getLevel(): int
    {
        return self::LEVEL_ERROR;
    }

    public function blockOrder(): bool
    {
        return true;
    }

    public function getParameters(): array
    {
        return [];
    }

    public function __construct()
    {
        parent::__construct('mettware.error.stopped');
    }
}
