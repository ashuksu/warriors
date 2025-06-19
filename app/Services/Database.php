<?php

namespace App\Services;

use PDO;
use PDOException;
use Exception;

/**
 * Database class
 * Handles database connection and query execution using PDO.
 */
class Database
{
    private static ?Database $instance = null;
    private ?PDO $pdo = null;

    /**
     * Private constructor to establish a PDO connection.
     * Reads connection parameters from environment variables.
     *
     * @throws Exception If connection fails.
     */
    private function __construct()
    {
        $db_connection = getenv('DB_CONNECTION') ?: 'pgsql';
        $db_host = getenv('DB_HOST') ?: 'localhost';
        $db_port = getenv('DB_PORT') ?: '5432';
        $db_database = getenv('DB_DATABASE') ?: 'myapp_db';
        $db_username = getenv('DB_USERNAME') ?: 'myuser';
        $db_password = getenv('DB_PASSWORD') ?: 'mypassword';

        $dsn = "{$db_connection}:host={$db_host};port={$db_port};dbname={$db_database}";

        try {
            $this->pdo = new PDO($dsn, $db_username, $db_password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection error: " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Get the singleton instance of the Database.
     *
     * @return Database
     * @throws Exception If connection fails during instantiation.
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the underlying PDO connection object.
     * Useful for direct PDO operations like exec() for schema files.
     *
     * @return PDO|null The PDO instance, or null if not connected.
     */
    public function getConnection(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * Execute an SQL query and return all results.
     *
     * @param string $sql The SQL query string.
     * @param array $params Optional array of parameters for a prepared statement.
     * @return array The fetched results as an associative array.
     * @throws Exception If query execution fails.
     */
    public function query(string $sql, array $params = []): array
    {
        if ($this->pdo === null) {
            throw new Exception("PDO instance is null. Database connection might have failed.");
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Query execution failed: " . $e->getMessage() . " SQL: " . $sql);
            throw new Exception("Database query error: " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Execute a SQL statement (INSERT, UPDATE, DELETE).
     *
     * @param string $sql The SQL statement string.
     * @param array $params Optional array of parameters for a prepared statement.
     * @return int The number of affected rows.
     * @throws Exception If statement execution fails.
     */
    public function execute(string $sql, array $params = []): int
    {
        if (isset($this->pdo) && $this->pdo === null) {
            throw new Exception("PDO instance is null. Database connection might have failed.");
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Statement execution failed: " . $e->getMessage() . " SQL: " . $sql);
            throw new Exception("Database statement error: " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Get the last inserted ID.
     *
     * @param string|null $name The name of the sequence object from which the ID should be returned.
     * @return string|false The ID of the last inserted row or sequence value, or false on failure.
     */
    public function lastInsertId(?string $name = null): string|false
    {
        if ($this->pdo === null) {
            return false;
        }
        return $this->pdo->lastInsertId($name);
    }
}