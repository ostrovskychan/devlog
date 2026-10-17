<?php

declare(strict_types=1);

use Gateways\HelloController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', [HelloController::class, 'hello']);

$app->run();
