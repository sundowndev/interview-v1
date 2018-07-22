<?php

namespace App\Service;

/**
 * Class Database
 * @package App\Service
 */
class Database
{
    private $conn;
    private $dsn;
    private $options;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->conn = null;

        $this->dsn = "mysql:host=" . getenv('MYSQL_HOST') . ":".getenv('MYSQL_PORT').";dbname=" . getenv('MYSQL_DBNAME');
        $this->options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );
    }

    /**
     * Get the PDO connection instance
     * @return \PDO
     */
    public function getConnection()
    {
        if (is_null($this->conn)) {
            try {
                $this->conn = new \PDO($this->dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASS'), $this->options);
            } //catch any errors
            catch (\PDOException $e) {
                exit($e->getMessage());
            }
        }

        return $this->conn;
    }

    /**
     * Handle PDO execution errors
     * @param \PDOStatement $stmt
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