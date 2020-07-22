<?php declare(strict_types=1);

namespace Mettware\Core\Route;

use Shopware\Core\Framework\Struct\Struct;

class StopRouteStruct extends Struct
{
    /**
     * @var bool
     */
    public $success;

    /**
     * @var string
     */
    public $message;
}
