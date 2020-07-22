<?php declare(strict_types=1);

namespace Mettware\Core\Route;

use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

class StopRouteResponse extends StoreApiResponse
{
    public function __construct(bool $success)
    {
        $struct = new StopRouteStruct();
        $struct->success = $success;
        $struct->message = 'status.ok';

        if (!$success) {
            $struct->message = 'status.error';
            $this->statusCode = 400;
        }

        parent::__construct($struct);
    }
}
