<?php

namespace App\Action;

use App\Domain\User\Service\UserCreator;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserCreateAction
{
  private $userCreator;

  public function __construct(UserCreator $userCreator)
  {
    $this->userCreator = $userCreator;
  }

  public function __invoke(
    ServerRequestInterface $request,
    ResponseInterface $response
  ): ResponseInterface {
    try {
      // Collect input from the HTTP request
      $data = (array)$request->getParsedBody();
      // Invoke the Domain with inputs and retain the result
      $user = $this->userCreator->getUser($data);

      if (empty($user)) {
        $userId = $this->userCreator->createUser($data);

        // Transform the result into the JSON representation
        $result = [
          'data' => $userId
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withStatus(201);
      } else {
        $error = array(
          "message" => "El usuario ya existe"
        );
        $response->getBody()->write((string)json_encode($error));

        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withStatus(409);
      }
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
