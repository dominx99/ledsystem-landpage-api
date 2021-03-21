<?php declare(strict_types = 1);

use App\Account\Domain\Repository\UserRepository;
use App\Account\Infrastructure\Repository\UserRepositoryDbal;
use App\Realization\Domain\Repository\RealizationRepository;
use App\Realization\Infrastructure\Repository\RealizationRepositoryDbal;
use App\Media\Domain\Repository\MediaRepository;
use App\Media\Infrastructure\Repository\MediaRepositoryDbal;
use App\Media\Domain\Repository\FileRepository;
use App\Media\Infrastructure\Repository\FileRepositoryDbal;

/** @var \DI\Container $container */

$container->set(
    UserRepository::class,
    DI\autowire(UserRepositoryDbal::class),
);

$container->set(
    RealizationRepository::class,
    DI\autowire(RealizationRepositoryDbal::class),
);

$container->set(
    MediaRepository::class,
    DI\autowire(MediaRepositoryDbal::class),
);

$container->set(
    FileRepository::class,
    DI\autowire(FileRepositoryDbal::class),
);
