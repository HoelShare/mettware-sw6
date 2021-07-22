<?php declare(strict_types=1);

namespace Mettware\Message;

use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;

class StopOrdersMessage extends SlackMessage
{
    private EntitySearchResult $orders;

    public function __construct(string $receiver, EntitySearchResult $orders)
    {
        parent::__construct($receiver, '');
        $this->orders = $orders;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getOrders(): EntitySearchResult
    {
        return $this->orders;
    }
}
