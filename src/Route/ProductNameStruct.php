<?php declare(strict_types=1);

namespace Mettware\Route;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Struct\Struct;

class ProductNameStruct extends Struct
{
    /** @var ProductEntity */
    private $product;

    /** @var string */
    private $name;

    public function __construct(ProductEntity $product)
    {
        $this->product = $product;
        $optionNames = [];
        foreach ($product->getOptions() as $option) {
            $optionNames[] = $option->getTranslation('name');
        }

        $this->name = $product->getTranslation('name');

        if ($optionNames) {
            $this->name .= sprintf(' - %s', implode(', ', $optionNames));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }
}
