<?php

namespace App\Action\CarAction;

use App\Domain\Car\CarService\Car;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteCarAction
{
  private $car;

  public function __construct(Car $car)
  {
    $this->car = $car;
  }

  public function __invoke(
    ServerRequestInterface $request,
    ResponseInterface $response,
    array $args
  ): ResponseInterface {
    try {
      // Invoke the Domain with inputs and retain the result
      $car = $this->car->deleteCar($args["id"]);

      // Transform the result into the JSON representation
      $result = [
        'data' => $car
      ];

      // Build the HTTP response
      $response->getBody()->write((string)json_encode($result));

      return $response
      ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "data" => $e->getMessage()
      );

      $response->getBody()->write(json_encode($error));
      return $response
      ->withStatus(500);
    }
  }
}