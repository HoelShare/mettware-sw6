<?php declare(strict_types=1);

namespace Mettware\Core\Statistics;

use Shopware\Core\Framework\Struct\Collection;

class StatisticsCollection extends Collection
{
    private float $contentPerPig;

    public function sortByMeatContent(): void
    {
        $this->sort(function (CustomerStatistics $customerA, CustomerStatistics $customerB) {
            return $customerB->getMeatContent() <=> $customerA->getMeatContent();
        });
    }

    public function getTotalCount(): float
    {
        $count = 0.0;
        /** @var CustomerStatistics $element */
        foreach ($this->getIterator() as $element) {
            $count += $element->getCount();
        }

        return $count;
    }

    public function getTotalMeatContent(): float
    {
        $meatContent = 0.0;
        /** @var CustomerStatistics $element */
        foreach ($this->getIterator() as $element) {
            $meatContent += $element->getMeatContent();
        }

        return $meatContent;
    }

    public function getContentPerPig(): float
    {
        return $this->contentPerPig;
    }

    public function setContentPerPig(float $contentPerPig): void
    {
        $this->contentPerPig = $contentPerPig;
    }

    public function getPigCount(): int
    {
      return (int)ceil($this->getTotalMeatContent() / $this->getContentPerPig());
    }

    public function getShareOfCurrentPig(): float
    {
        return ($this->getTotalMeatContent() % $this->getContentPerPig()) / $this->getContentPerPig() * 100;
    }
}
