<?php declare(strict_types=1);

namespace Mettware\Core\Route;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Struct\Struct;

class ProductNameStruct extends Struct
{
    /** @var string */
    private $name;

    public function __construct(string $productName)
    {
        $this->name = $productName;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
