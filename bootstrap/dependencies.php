<?php declare(strict_types = 1);

/** @var \DI\Container $container */

$container->set(
    \App\Shared\Domain\Validation\Validator::class,
    DI\autowire(\App\Shared\Infrastructure\Validation\RespectValidator::class),
);

require_once "dependencies/database.php";
require_once "dependencies/logger.php";
require_once "dependencies/repository.php";
