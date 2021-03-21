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
            ->addColumn("mainImageId", "string", ['null' => true])
            ->addColumn("name", "string")
            ->addColumn("slug", "string")
            ->addColumn("description", "text")
            ->addColumn("createdAt", "datetime", ["default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updatedAt", "datetime", ["null" => true, "update" => "CURRENT_TIMESTAMP"])
            ->create();
    }
}
