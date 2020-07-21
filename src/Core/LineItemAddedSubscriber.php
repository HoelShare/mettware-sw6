<?php declare(strict_types=1);

namespace Mettware\Core;

use Shopware\Core\Checkout\Cart\Event\LineItemAddedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class LineItemAddedSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LineItemAddedEvent::class => 'lineItemAdded',
        ];
    }

    public function lineItemAdded(LineItemAddedEvent $addedEvent): void
    {
        $extra = $this->extractExtra($addedEvent->getLineItem()->getId());
        if (!$extra) {
            return;
        }

        $addedEvent->getLineItem()->setPayloadValue('extra', $extra);
    }

    private function extractExtra(string $lineItemId): ?string
    {
        $masterRequest = $this->requestStack->getMasterRequest();
        if (!$masterRequest) {
            return null;
        }

        $extra = $masterRequest->request->get('lineItems')[$lineItemId]['extra'] ?? null;

        if (!$extra) {
            return null;
        }

        return $extra;
    }
}
