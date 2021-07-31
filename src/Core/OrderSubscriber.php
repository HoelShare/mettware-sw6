<?php declare(strict_types=1);

namespace Mettware\Core;

use Shopware\Core\Checkout\Cart\CartEvents;
use Shopware\Core\Checkout\Cart\Event\CheckoutOrderPlacedEvent;
use Shopware\Core\Checkout\Order\OrderEvents;
use Shopware\Core\Framework\Adapter\Cache\CacheClearer;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use Shopware\Storefront\Framework\Cache\CacheStore;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderSubscriber implements EventSubscriberInterface
{
    private bool $httpCacheEnabled;
    private CacheClearer $cacheClearer;

    public function __construct(bool $httpCacheEnabled, CacheClearer $cacheClearer)
    {
        $this->httpCacheEnabled = $httpCacheEnabled;
        $this->cacheClearer = $cacheClearer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OrderEvents::ORDER_WRITTEN_EVENT => 'invalidateHttpCache',
        ];
    }

    public function invalidateHttpCache(EntityWrittenEvent $event): void
    {
        if (!$this->httpCacheEnabled) {
            return;
        }

        $this->cacheClearer->clear();
    }
}
