<?php declare(strict_types=1);

namespace Mettware\Core\Order;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                 add(MettwareOrderEntity $entity)
 * @method void                 set(string $key, MettwareOrderEntity $entity)
 * @method MettwareOrderEntity[]    getIterator()
 * @method MettwareOrderEntity[]    getElements()
 * @method MettwareOrderEntity|null get(string $key)
 * @method MettwareOrderEntity|null first()
 * @method MettwareOrderEntity|null last()
 */
class MettwareOrderCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return MettwareOrderEntity::class;
    }

}
