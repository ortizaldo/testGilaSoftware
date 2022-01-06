<?php

use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

// Register routes
(require __DIR__ . '/routes.php')($app);

// Register middleware
(require __DIR__ . '/middleware.php')($app);

// $customErrorHandler = function (
//   ServerRequestInterface $request,
//   Throwable $exception,
//   bool $displayErrorDetails,
//   bool $logErrors,
//   bool $logErrorDetails
// ) use ($app) {
//   $payload = ['error' => $exception->getMessage()];

//   $response = $app->getResponseFactory()->createResponse();
//   $response->getBody()->write(
//     json_encode($payload, JSON_UNESCAPED_UNICODE)
//   );

//   return $response;
// };

// // Add Error Middleware
// $errorMiddleware = $app->addErrorMiddleware(true, true, true);
// $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

return $app;