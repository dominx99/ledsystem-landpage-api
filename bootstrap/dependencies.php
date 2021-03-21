<?php declare(strict_types = 1);

/** @var \DI\Container $container */

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
    getenv('APP_URL'),
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

require_once "dependencies/database.php";
require_once "dependencies/logger.php";
require_once "dependencies/repository.php";
