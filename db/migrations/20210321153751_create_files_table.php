<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateFilesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("files", ["id" => false, "primary_key" => "id"]);

        $table
            ->addColumn("id", "string")
            ->addColumn("mediaId", "string")
            ->addColumn("type", "string")
            ->addColumn("filename", "string")
            ->addColumn("path", "string")
            ->addColumn("fullPath", "string")
            ->addColumn("url", "string")
            ->addColumn("createdAt", "datetime", ["default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updatedAt", "datetime", ["null" => true, "update" => "CURRENT_TIMESTAMP"])
            ->create();
    }
}
