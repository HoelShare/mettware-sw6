<?php declare(strict_types=1);

namespace Mettware\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1594766980MettwareOrder extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1594766980;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('CREATE TABLE mw_order (
            `id` BINARY(16) NOT NULL PRIMARY KEY,
            `order_stop_date` DATETIME(3) NOT NULL,
            `created_at` DATETIME(3) NOT NULL,
            `updated_at` DATETIME(3) NULL,
            UNIQUE (`order_stop_date`)
)');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
