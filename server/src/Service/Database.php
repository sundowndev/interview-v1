<?php

namespace App\Service;

/**
 * Class Database
 * @package App\Service
 */
class Database
{
    private $dotEnvParser;
    private $conn;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->dotEnvParser = new DotEnvParser();
        $this->dotEnvParser
            ->parse()
            ->toEnv()
            ->toArray();

        $dsn = "mysql:host=" . $_ENV['MYSQL_HOST'] . ";dbname=" . $_ENV['MYSQL_DBNAME'];
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->conn = new \PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS'], $options);
        } //catch any errors
        catch (\PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Get the PDO connection instance
     *
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Handle PDO execution errors
     * @param PDOStatement $stmt
     * @return void
     */
    public function errorHandler(\PDOStatement $stmt) : void
    {
        if ($stmt->errorCode() !== '00000') {
            var_dump($stmt->errorInfo());
            die();
        }
    }
}