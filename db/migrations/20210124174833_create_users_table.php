<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("users", ["id" => false, "primary_key" => "id"]);

        $table
            ->addColumn("id", "string")
            ->addColumn("name", "string")
            ->addColumn("email", "string")
            ->addColumn("password", "string")
            ->addColumn("accessToken", "string", ['null' => true])
            ->addColumn("createdAt", "datetime", ["default" => "CURRENT_TIMESTAMP"])
            ->addColumn("updatedAt", "datetime", ["null" => true, "update" => "CURRENT_TIMESTAMP"])
            ->create();
    }
}
