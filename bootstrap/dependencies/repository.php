<?php declare(strict_types = 1);

use App\Account\Domain\Repository\UserRepository;
use App\Account\Infrastructure\Repository\UserRepositoryDbal;

/** @var \DI\Container $container */

$container->set(
    UserRepository::class,
    DI\autowire(UserRepositoryDbal::class),
);
