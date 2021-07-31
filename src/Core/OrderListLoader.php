<?php declare(strict_types=1);

namespace Mettware\Core;

use Mettware\Core\Route\ProductNameStruct;
use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity;
use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
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
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class OrderListLoader
{
    /**
     * @var EntityRepositoryInterface
     */
    private $orderRepository;

    public function __construct(EntityRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria();
        $startOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0);
        $endOfDay = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTime(0, 0)->add(new \DateInterval('P1D'));

        $criteria->addFilter(new RangeFilter('createdAt', [
            RangeFilter::GTE => $startOfDay->format('Y-m-d H:i:s'),
            RangeFilter::LTE => $endOfDay->format('Y-m-d H:i:s'),
        ]));

        $this->addAssociations($criteria);
        $this->addAggregations($criteria);

        $criteria->addSorting(new FieldSorting('orderNumber'));
        $criteria->addSorting(new FieldSorting('lineItems.type', FieldSorting::ASCENDING));

        return $criteria;
    }

    public function load(Criteria $criteria, Context $context): EntitySearchResult
    {
        $orders = $this->orderRepository->search($criteria, $context);

        return $this->enhanceOrders($orders);
    }

    public function enhanceOrders(EntitySearchResult $orders): EntitySearchResult
    {
        /** @var TermsResult $terms */
        $this->addNameExtensions($orders->getAggregations()->get('count'), $orders);
        $this->addNameExtensions($orders->getAggregations()->get('custom-count'), $orders);

        return $orders;
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
                } else if ($lineItem->getType() === 'customized-products-option') {
                    if (($lineItem->getPayload()['type'] ?? '') === 'textfield') {
                        $labels[] = $lineItem->getPayload()['value'];
                        continue;
                    }
                    $labels[] = $lineItem->getLabel();
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

    /**
     * @param Criteria $criteria
     */
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

    /**
     * @param Criteria $criteria
     */
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
}
