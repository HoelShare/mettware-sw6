<?php declare(strict_types=1);

namespace Mettware\Core\Order;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class MettwareOrderEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var \DateTimeInterface
     */
    private $stopDate;

    public function getStopDate(): \DateTimeInterface
    {
        return $this->stopDate;
    }

    public function setStopDate(\DateTimeInterface $stopDate): void
    {
        $this->stopDate = $stopDate;
    }
}
