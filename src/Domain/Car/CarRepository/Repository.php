<?php

namespace App\Domain\Car\CarRepository;
use DomainException;
use PDO;

/**
 * Repository.
 */
final class Repository
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
    public function __construct(PDO $connection, ReaderRepository $readerRepository)
    {
        $this->connection = $connection;
        $this->readerRepository = $readerRepository;
    }

    /**
     * Insert car row.
     *
     * @param array $car The car
     *
     * @return int The new ID
     */
    public function insertCar(array $car)
    {   
        // get type car
        $row = [
            'carName' => $car['carName'],
            'typeCar' => $car['typeCar'],
            'reels' => $car['reels'],
            'enginePower' => $car['enginePower'],
            'motor' => $car['motor'],
            'color' => $car['color'],
        ];

        $sql = "INSERT INTO cars SET carName=:carName, typeCar=:typeCar, reels=:reels, enginePower=:enginePower, motor=:motor, color=:color;";

        $statement = $this->connection->prepare($sql);
        $statement->execute($row);

        $result = null;
        if (!$statement) {
            throw new DomainException(sprintf('No se pudo insertar el registro: %s', $car['carName']));
        }else {
            $id = (int)$this->connection->lastInsertId();
            $result = $this->readerRepository->getCarById($id);
        }

        return $result;
    }

    public function updateCar(array $car, int $id)
    {
        // get type car
        $row = [
            'carName' => $car['carName'],
            'typeCar' => $car['idTypeCar'],
            'reels' => $car['reels'],
            'enginePower' => $car['enginePower'],
            'motor' => $car['motor'],
            'color' => $car['color'],
            'idCar' => $id,
        ];

        $sql = "UPDATE cars SET 
                carName=:carName, 
                typeCar=:typeCar, 
                reels=:reels, 
                enginePower=:enginePower, 
                motor=:motor, 
                color=:color
                WHERE idCar=:idCar;";

        $statement = $this->connection->prepare($sql);
        $result = $statement->execute($row);
        $data = null;
        
        if ($result) {
            $data = $this->readerRepository->getCarById($id);
        }

        return $data;
    }

    public function deleteCar(int $id)
    {
        // get type car
        $row = [
            'idCar' => $id,
        ];

        $sql = "DELETE FROM cars
                WHERE idCar=:idCar;";

        $statement = $this->connection->prepare($sql);
        $result = $statement->execute($row);
        
        return $result;
    }


    public function insertTypeCar(array $typeCar): int
    {
        $row = [
            'typeName' => $typeCar['typeName'],
            'typeCar' => $typeCar['typeCar'],
        ];

        $sql = "INSERT INTO typeCar SET 
                typeName=:typeName,
                typeCar=:typeCar;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }
}