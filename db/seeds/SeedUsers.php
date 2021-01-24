<?php


use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Uuid;

class SeedUsers extends AbstractSeed
{
    public function run()
    {
        $this->table('users')->insert([
            [
                'id' => (string) Uuid::uuid4(),
                'name' => 'Graku',
                'email' => 'graku@ledsystem.com.pl',
                'password' => password_hash('Ledsystem!', PASSWORD_BCRYPT),
            ],
        ])->saveData();
    }
}
