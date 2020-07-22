<?php declare(strict_types=1);

namespace Mettware\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('productSort', [ProductSortExtension::class, 'sort'])
        ];
    }

}
