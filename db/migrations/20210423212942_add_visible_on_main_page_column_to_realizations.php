<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddVisibleOnMainPageColumnToRealizations extends AbstractMigration
{
    public function change(): void
    {
        $this
            ->table('realizations')
            ->addColumn('visibleOnMainPage', 'boolean', ["default" => false])
            ->update();
    }
}
