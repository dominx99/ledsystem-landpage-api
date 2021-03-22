<?php declare(strict_types = 1);

use Dotenv\Dotenv;

$config = [];

if (getenv("APP_ENV") === "production") {
    $config = parse_url(getenv("DATABASE_URL"));

    $config = [
        "host"     => $config['host'],
        "user"     => $config['user'],
        "password" => $config['pass'],
        "dbname"   => substr($config["path"], 1),
    ];
} else {
    $dotenv= Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $config = [
        'host'     => getenv("DB_HOST"),
        'user'     => getenv("DB_USER"),
        'password' => getenv("DB_PASSWORD"),
        'dbname'   => getenv("DB_NAME"),
    ];
}

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => env('APP_ENV'),
        env('APP_ENV') => [
            'adapter' => 'mysql',
            'host'    => $config["host"],
            'name'    => $config["dbname"],
            'user'    => $config["user"],
            'pass'    => $config["password"],
            'port'    => '3306',
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
