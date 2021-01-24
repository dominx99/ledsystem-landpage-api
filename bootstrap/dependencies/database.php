<?php declare(strict_types = 1);

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

$config = [
    'host'     => env("DB_HOST"),
    'user'     => env("DB_USER"),
    'password' => env("DB_PASSWORD"),
    'dbname'   => env("DB_NAME"),
];

/** @var \DI\Container $container */

$container->set(Connection::class, fn() => DriverManager::getConnection(array_merge($config, [
    'driver' => getenv("DB_DRIVER"),
])));
