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
    public function insertCar(array $car): int
    {
        $reels = $car['reels'];
        $typeCar = [];
        if ($reels > 2) {
            $typeCar = $this->readerRepository->getCarTypeByType(1);
        }else{
            $typeCar = $this->readerRepository->getCarTypeByType(2);
        }
        
        // get type car
        $row = [
            'carName' => $car['carName'],
            'typeCar' => $typeCar['idTypeCar'],
            'reels' => $car['reels'],
            'enginePower' => $car['enginePower'],
            'motor' => $car['motor'],
            'color' => $car['color'],
        ];

        $sql = "INSERT INTO cars SET 
                carName=:carName, 
                typeCar=:typeCar, 
                reels=:reels, 
                enginePower=:enginePower, 
                motor=:motor, 
                color=:color;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
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