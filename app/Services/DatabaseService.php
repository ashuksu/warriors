<?php

namespace App\Services;

use PDO;
use PDOException;
use Exception;

/**
 * Provides database connection and query execution using PDO.
 */
class DatabaseService
{
    private ?PDO $pdo = null;

    public function __construct(ConfigService $config)
    {
        $dbConfig = $config->get('database');
        $dsn = "{$dbConfig['connection']}:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['name']}";

        try {
            $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection error: " . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Gets the underlying PDO connection.
     *
     * @return PDO|null PDO instance or null.
     */
    public function getConnection(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * Executes an SQL query and returns all results.
     *
     * @param string $sql SQL query string.
     * @param array $params Optional parameters.
     * @return array Fetched results.
     * @throws Exception If query execution fails.
     */
    public function query(string $sql, array $params = []): array
    {
        if ($this->pdo === null) {
            throw new Exception("PDO instance is null.");
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
     * Executes an SQL statement (INSERT, UPDATE, DELETE).
     *
     * @param string $sql SQL statement string.
     * @param array $params Optional parameters.
     * @return int Number of affected rows.
     * @throws Exception If statement execution fails.
     */
    public function execute(string $sql, array $params = []): int
    {
        if ($this->pdo === null) {
            throw new Exception("PDO instance is null.");
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
     * Gets the last inserted ID.
     *
     * @param string|null $name Sequence name.
     * @return string|false Last inserted ID or false on failure.
     */
    public function lastInsertId(?string $name = null): string|false
    {
        if ($this->pdo === null) {
            return false;
        }
        return $this->pdo->lastInsertId($name);
    }
}