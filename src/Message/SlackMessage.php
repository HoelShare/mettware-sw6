<?php declare(strict_types=1);

namespace Mettware\Message;

class SlackMessage
{
    protected string $receiver;

    protected string $message;

    public function __construct(string $receiver, string $message)
    {
        $this->receiver = $receiver;
        $this->message = $message;
    }

    public function getReceiver(): string
    {
        return $this->receiver;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
