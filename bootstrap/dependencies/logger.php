<?php declare(strict_types = 1);

use Monolog\Formatter\LineFormatter;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$container->set(LoggerInterface::class, function () {
    $log = new Logger('main');

    // TODO: Change to daily logger
    $debugHandler = new StreamHandler(__DIR__ . '/../../logs/main.log');
    $debugHandler->setFormatter(new LineFormatter(null, null, true, true));

    $log->pushHandler($debugHandler);

    return $log;
});
