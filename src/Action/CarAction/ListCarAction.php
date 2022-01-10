<?php

namespace App\Action\CarAction;

use App\Domain\Car\CarService\Car;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListCarAction
{
  private $car;

  public function __construct(Car $car)
  {
    $this->car = $car;
  }

  public function __invoke(
    ServerRequestInterface $request,
    ResponseInterface $response
  ): ResponseInterface {
    try {
      // Invoke the Domain with inputs and retain the result
      $cars = $this->car->listCar();

      // Transform the result into the JSON representation
      $result = [
        'data' => $cars
      ];

      // Build the HTTP response
      $response->getBody()->write((string)json_encode($result));

      return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(201);
    } catch (PDOException $e) {
      $error = array(
        "data" => $e->getMessage()
      );

      $response->getBody()->write(json_encode($error));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
  }
}