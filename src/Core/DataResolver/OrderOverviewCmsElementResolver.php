<?php
declare(strict_types=1);

namespace Mettware\Core\DataResolver;

use Mettware\Core\Order\MettwareOrderDefinition;
use Mettware\Core\Route\ProductNameStruct;
use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity;
use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Checkout\Order\OrderDefinition;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Bucket\FilterAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Bucket\TermsAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\SumAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Bucket\TermsResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;

class OrderOverviewCmsElementResolver extends AbstractCmsElementResolver
{
    public function getType(): string
    {
        return 'mettware-order-overview';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $startOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0);
        $endOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0)->add(
            new \DateInterval('P1D')
        );

        $orderCriteria = $this->getOrderCriteria($startOfDay, $endOfDay);
        $mettwareOrder = $this->getStopCriteria($startOfDay, $endOfDay);
        $criteriaCollection = new CriteriaCollection();
        $criteriaCollection->add('order_' . $slot->getUniqueIdentifier(), OrderDefinition::class, $orderCriteria);
        $criteriaCollection->add('mettware_order', MettwareOrderDefinition::class, $mettwareOrder);

        return $criteriaCollection;
    }

    private function addAssociations(Criteria $criteria): void
    {
        $criteria->addAssociation('lineItems.product');
        $criteria->addAssociation('lineItems.children');
        $criteria->addAssociation('lineItems.children.product');
        $criteria->addAssociation('lineItems.children.product.options');
        $criteria->addAssociation('lineItems.children.product.manufacturer');
        $criteria->addAssociation('lineItems.product.manufacturer');
        $criteria->addAssociation('lineItems.product.options');
        $criteria->addAssociation('customer');
    }

    private function addAggregations(Criteria $criteria): void
    {
        $criteria->addAggregation(
            new FilterAggregation(
                'products',
                new TermsAggregation(
                    'count',
                    'order.lineItems.product.id',
                    null,
                    new FieldSorting('order.lineItems.product.name'),
                    new SumAggregation('product-quantity', 'order.lineItems.quantity')
                ),
                [
                    new MultiFilter(MultiFilter::CONNECTION_AND,
                                    [
                                        new EqualsFilter('order.lineItems.type', 'product'),
                                        new EqualsFilter('order.lineItems.parentId', null),
                                    ]
                    )
                ]
            )
        );

        $criteria->addAggregation(
            new FilterAggregation(
                'custom-products',
                new TermsAggregation(
                    'custom-count',
                    'order.lineItems.id',
                    null,
                    new FieldSorting('order.lineItems.label'),
                    new SumAggregation('custom-quantity', 'order.lineItems.quantity')
                ),
                [
                    new EqualsFilter('order.lineItems.type', 'customized-products'),
                ]
            )
        );

        $criteria->addAggregation(new SumAggregation('sum', 'amountTotal'));
        $criteria->addAggregation(
            new FilterAggregation(
                'count-filter',
                new SumAggregation(
                    'total-count',
                    'order.lineItems.quantity'
                ),
                [
                    new EqualsAnyFilter(
                        'order.lineItems.type',
                        ['product']
                    )
                ]
            )
        );
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        /** @var EntitySearchResult $orders */
        $orders = $result->get('order_' . $slot->getUniqueIdentifier());
        if (!$orders) {
            return;
        }
        $mettwareOrder = $result->get('mettware_order');
        $isStopped = !($mettwareOrder === null || $mettwareOrder->count() === 0);

        $this->addNameExtensions($orders->getAggregations()->get('count'), $orders);
        $this->addNameExtensions($orders->getAggregations()->get('custom-count'), $orders);

        $slot->setData(new OrderOverviewStruct($orders, $isStopped));
    }

    private function addNameExtensions(TermsResult $terms, EntitySearchResult $orders): void
    {
        foreach ($terms->getBuckets() as $bucket) {
            $productName = $this->findProductNameById($orders->getEntities(), $bucket->getKey())
                ?? $this->findCustomProductNameById($orders->getEntities(), $bucket->getKey());
            if (!$productName) {
                continue;
            }

            $bucket->addExtension('name', new ProductNameStruct($productName));
        }
    }

    private function findProductNameById(OrderCollection $orders, string $productId): ?string
    {
        foreach ($orders as $order) {
            foreach ($order->getLineItems() as $lineItem) {
                if ($lineItem->getProductId() === $productId && (($product = $lineItem->getProduct()) !== null)) {
                    return $this->getProductName($product);
                }
            }
        }

        return null;
    }

    private function findCustomProductNameById(OrderCollection $orders, string $productId): ?string
    {
        foreach ($orders as $order) {
            $items = $order->getLineItems()->get($productId);
            if (!$items) {
                continue;
            }

            $items = $items->getExtension('children');
            $product = null;
            $labels = [];
            /** @var OrderLineItemEntity $lineItem */
            foreach ($items as $lineItem) {
                if ($lineItem->getType() === 'product') {
                    $product = $lineItem->getProduct();
                } else {
                    if ($lineItem->getType() === 'customized-products-option') {
                        if (($lineItem->getPayload()['type'] ?? '') === 'textfield') {
                            $labels[] = $lineItem->getPayload()['value'];
                            continue;
                        }
                        $labels[] = $lineItem->getLabel();
                    }
                }
            }
            if (!$product) {
                continue;
            }

            $name = $this->getProductName($product);

            if ($labels) {
                $name .= sprintf(' + %s', implode(' + ', $labels));
            }

            return $name;
        }

        return null;
    }

    private function getProductName(ProductEntity $product): string
    {
        $optionNames = [];
        foreach ($product->getOptions() as $option) {
            $optionNames[] = $option->getTranslation('name');
        }

        $name = $product->getTranslation('name');

        if ($optionNames) {
            $name .= sprintf(' - %s', implode(', ', $optionNames));
        }

        return $name;
    }

    private function getOrderCriteria($startOfDay, $endOfDay): Criteria
    {
        $criteria = new Criteria();
        $criteria->addFilter(
            new RangeFilter('createdAt', [
                RangeFilter::GTE => $startOfDay->format('Y-m-d H:i:s'),
                RangeFilter::LTE => $endOfDay->format('Y-m-d H:i:s'),
            ])
        );

        $this->addAssociations($criteria);
        $this->addAggregations($criteria);

        $criteria->addSorting(new FieldSorting('orderNumber'));
        $criteria->addSorting(new FieldSorting('lineItems.type', FieldSorting::ASCENDING));
        return $criteria;
    }

    private function getStopCriteria($startOfDay, $endOfDay): Criteria
    {
        $criteria = new Criteria();

        $criteria->addFilter(
            new RangeFilter('stopDate', [
                RangeFilter::GTE => $startOfDay->format('Y-m-d H:i:s'),
                RangeFilter::LTE => $endOfDay->format('Y-m-d H:i:s'),
            ])
        );
        return $criteria;
    }
}
