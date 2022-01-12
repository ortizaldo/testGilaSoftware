<?php

namespace App\Action\CarAction;

use App\Domain\Car\CarService\Car;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCarAction
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
      // Collect input from the HTTP request
      $data = (array)$request->getParsedBody();
      // Invoke the Domain with inputs and retain the result
      $carId = $this->car->createCar($data);

      // Transform the result into the JSON representation
      $result = [
        'data' => $carId
      ];

      // Build the HTTP response
      $response->getBody()->write((string)json_encode($result));

      return $response
      ->withHeader('Content-Type', 'application/json')
      ->withHeader('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE')
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "data" => $e->getMessage()
      );

      $response->getBody()->write(json_encode($error));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withHeader('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withStatus(500);
    }
  }
}