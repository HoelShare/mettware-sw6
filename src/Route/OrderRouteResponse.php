<?php declare(strict_types=1);

namespace Mettware\Route;

use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

class OrderRouteResponse extends StoreApiResponse
{
    /**
     * @var EntitySearchResult
     */
    protected $object;

    /**
     * @var bool
     */
    protected $isStopped;

    public function __construct(Struct $object, bool $isStopped)
    {
        $this->isStopped = $isStopped;

        parent::__construct($object);
    }

    public function isStopped(): bool
    {
        return $this->isStopped;
    }

    public function getObject(): Struct
    {
        return $this->object;
    }
}
