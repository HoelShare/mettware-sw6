<?php

declare(strict_types=1);

namespace Mettware\Core\Statistics;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Bucket\FilterAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Bucket\TermsAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\MaxAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\SumAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;

class StatisticsLoader
{
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria();

        $criteria->addAggregation(
            new FilterAggregation(
                'meat-filter',
                new TermsAggregation(
                    'customerNumber',
                    'order.orderCustomer.customerNumber',
                    null,
                    null,
                    new TermsAggregation(
                        'meat-content',
                        'order.lineItems.product.customFields.custom_mettware_meat_content',
                        null,
                        null,
                        new SumAggregation(
                            'count-content',
                            'order.lineItems.quantity'
                        )
                    ),
                ),
                [
                    new RangeFilter(
                        'order.lineItems.product.customFields.custom_mettware_meat_content',
                        [RangeFilter::GT => 0]
                    ),
                ]
            )
        );

        return $criteria;
    }

    public function enrich(EntitySearchResult $entitySearchResult): EntitySearchResult
    {
        return $entitySearchResult;
    }
}
