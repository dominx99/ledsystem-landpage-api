<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateRealizationsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("realizations", ["id" => false, "primary_key" => "id"]);

        $table
            ->addColumn("id", "string")
            ->addColumn("userId", "string")
            ->addColumn("name", "string")
            ->addColumn("description", "string")
            ->addColumn("createdAt", "datetime", ["default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updatedAt", "datetime", ["null" => true, "update" => "CURRENT_TIMESTAMP"])
            ->create();
    }
}
