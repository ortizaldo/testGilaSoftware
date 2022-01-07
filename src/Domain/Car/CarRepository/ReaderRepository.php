<?php

namespace App\Domain\Car\CarRepository;

use DomainException;
use PDO;

/**
 * Repository.
 */
class ReaderRepository
{
  /**
   * @var PDO The database connection
   */
  private $connection;

  /**
   * Constructor.
   *
   * @param PDO $connection The database connection
   */
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }

  /**
   * Get type car by the given type.
   *
   * @param int $typeId The carType id
   *
   * @throws DomainException
   *
   * @return array The carType row
   */
  public function getCarTypeByType(int $carType): array
  {
    $sql = "SELECT idTypeCar, typeName, typeCar FROM typeCar WHERE typeCar = :typeCar;";
    $statement = $this->connection->prepare($sql);
    $statement->execute(['typeCar' => $carType]);

    $row = $statement->fetch();

    if (!$row) {
      throw new DomainException(sprintf('Type car not found: %s', $carType));
    }

    return $row;
  }
}
