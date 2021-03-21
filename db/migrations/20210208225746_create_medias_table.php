<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMediasTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("medias", ["id" => false, "primary_key" => "id"]);

        $table
            ->addColumn("id", "string")
            ->addColumn("realizationId", "string")
            ->addColumn("createdAt", "datetime", ["default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updatedAt", "datetime", ["null" => true, "update" => "CURRENT_TIMESTAMP"])
            ->create();
    }
}
