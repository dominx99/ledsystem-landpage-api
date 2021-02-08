<?php declare(strict_types = 1);

use App\Account\Domain\Repository\UserRepository;
use App\Account\Infrastructure\Repository\UserRepositoryDbal;
use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Infrastructure\Repository\RealizationRepositoryDbal;

/** @var \DI\Container $container */

$container->set(
    UserRepository::class,
    DI\autowire(UserRepositoryDbal::class),
);

$container->set(
    RealizationRepository::class,
    DI\autowire(RealizationRepositoryDbal::class),
);
