<?php declare(strict_types = 1);

/** @var \DI\Container $container */

if (! env('APP_ENV')) {
    $dotenv= \Dotenv\Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
    $dotenv->load();
}

$container->set(
    \App\Shared\Domain\Validation\Validator::class,
    DI\autowire(\App\Shared\Infrastructure\Validation\RespectValidator::class),
);

$container->set(
    \App\Media\Domain\Uploader\MultipleFileUploaderInterface::class,
    DI\autowire(\App\Media\Infrastructure\Uploader\MultipleFileUploader::class),
);

$container->set(
    'baseUrl',
    env('APP_URL'),
);

$container->set(
    'storageDirectory',
    DI\string('storage'),
);

$container->set(
    'realizationsDirectory',
    DI\string('{storageDirectory}/realizations'),
);

$container->set(
    \App\Media\Domain\Builder\FileImageBuilderInterface::class,
    DI\autowire(\App\Media\Infrastructure\Builder\FileImageBuilder::class),
);

$container->set(
    \App\Realization\Domain\Hydrator\RealizationHydratorInterface::class,
    DI\autowire(\App\Realization\Infrastructure\Hydrator\RealizationHydrator::class),
);


require_once "dependencies/database.php";
require_once "dependencies/logger.php";
require_once "dependencies/repository.php";
