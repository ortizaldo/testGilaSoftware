<?php

namespace App\Domain\User\Repository;

use DomainException;
use PDO;

/**
 * Repository.
 */
final class UserCreatorRepository
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
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ];

        $sql = "INSERT INTO users SET 
                username=:username, 
                first_name=:first_name, 
                last_name=:last_name, 
                email=:email;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
        
    }

    public function getUser(array $user): array
    {
        $username = $user["username"];

        $sql = "SELECT * FROM users 
                WHERE username=:username";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':username', $username);

        $stmt->execute();

        $row = $stmt->fetch();

        if (!$row) {
            $row = [];
        }

        return $row;
    }
}