<?php

namespace App\Domain\Car\CarService;

use App\Domain\Car\CarRepository\Repository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class Car
{
  /**
   * @var Repository
   */
  private $repository;

  /**
   * The constructor.
   *
   * @param Repository $repository The repository
   */
  public function __construct(Repository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * Create a new car.
   *
   * @param array $data The form data
   *
   * @return int The new car ID
   */
  public function createCar(array $data)
  {
    // Insert car
    $carId = $this->repository->insertCar($data);

    return $carId;
  }

  /**
   * Create a new type car.
   *
   * @param array $data The form data
   *
   * @return int The new type car ID
   */
  public function createTypeCar(array $data)
  {
    // Insert car
    $carId = $this->repository->insertTypeCar($data);

    return $carId;
  }
}