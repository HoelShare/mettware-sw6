<?php declare(strict_types=1);

namespace Mettware\Core\Statistics;

use Shopware\Core\Framework\Struct\Struct;

class CustomerStatistics extends Struct
{
    private string $customerNumber;
    private string $firstName;
    private string $lastName;
    private float $count = 0.0;
    private float $meatContent = 0.0;

    public function getCustomerNumber(): string
    {
        return $this->customerNumber;
    }

    public function setCustomerNumber(string $customerNumber): void
    {
        $this->customerNumber = $customerNumber;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getCount(): float
    {
        return $this->count;
    }

    public function setCount(float $count): void
    {
        $this->count = $count;
    }

    public function getMeatContent(): float
    {
        return $this->meatContent;
    }

    public function setMeatContent(float $meatContent): void
    {
        $this->meatContent = $meatContent;
    }

    public function addMeatContent(float $content): self
    {
        $this->meatContent += $content;

        return $this;
    }

    public function addCount(float $count): self
    {
        $this->count += $count;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
