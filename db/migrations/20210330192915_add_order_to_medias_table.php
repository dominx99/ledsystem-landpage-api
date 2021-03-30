<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddOrderToMediasTable extends AbstractMigration
{
    public function change(): void
    {
        $this
            ->table('medias')
            ->addColumn('order', 'integer', ["default" => 0])
            ->update();
    }
}
