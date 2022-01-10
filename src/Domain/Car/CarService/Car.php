<?php

namespace App\Domain\Car\CarService;

use App\Domain\Car\CarRepository\Repository;
use App\Domain\Car\CarRepository\ReaderRepository;
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
  private $readerRepository;

  /**
   * The constructor.
   *
   * @param Repository $repository The repository
   */
  public function __construct(Repository $repository, ReaderRepository $readerRepository)
  {
    $this->repository = $repository;
    $this->readerRepository = $readerRepository;
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

  public function updateCar(array $data, int $id)
  {
    // Update car
    $carId = $this->repository->updateCar($data, $id);

    return $carId;
  }

  public function deleteCar(int $data)
  {
    // Delete car
    $carId = $this->repository->deleteCar($data);

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

  /**
   * List for all cars.
   *
   * @param array $data The form data
   *
   * @return array The all cars
   */
  public function listCar()
  {
    $cars = $this->readerRepository->getCars();
    return $cars;
  }
}