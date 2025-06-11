<?php

namespace Services;

use PDO;
use PDOException;
use Exception;

/**
 * Service for managing database connection and basic queries.
 */
class Database
{
    private static ?self $instance = null;
    private ?PDO $connection = null;

    /**
     * Private constructor to enforce singleton pattern.
     */
    private function __construct()
    {
        $this->connect();
    }

    /**
     * Get the singleton instance of the Database service.
     *
     * @return Database
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Establish a PDO connection to the database.
     *
     * @throws Exception If connection fails.
     */
    private function connect(): void
    {
        // Get database credentials from environment variables
        $host = getenv('DB_HOST') ?: 'db';
        $port = getenv('DB_PORT') ?: '5432';
        $db   = getenv('DB_DATABASE') ?: 'myapp_db';
        $user = getenv('DB_USERNAME') ?: 'myuser';
        $pass = getenv('DB_PASSWORD') ?: 'mypassword';

        $dsn = "pgsql:host={$host};port={$port};dbname={$db}";

        try {
            $this->connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection error. Please check logs.");
        }
    }

    /**
     * Get the PDO connection object.
     *
     * @return PDO
     * @throws Exception If connection is not established.
     */
    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $this->connect(); // Reconnect if needed
        }
        return $this->connection;
    }

    /**
     * Execute a SQL query and fetch all results.
     *
     * @param string $sql SQL query string.
     * @param array $params Optional array of parameters for prepared statement.
     * @return array Fetched data.
     * @throws Exception If query fails.
     */
    public function query(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage() . " Query: " . $sql);
            throw new Exception("Database query failed.");
        }
    }

    /**
     * Execute a SQL statement (e.g., INSERT, UPDATE, DELETE).
     *
     * @param string $sql SQL statement string.
     * @param array $params Optional array of parameters for prepared statement.
     * @return int Number of affected rows.
     * @throws Exception If statement fails.
     */
    public function execute(string $sql, array $params = []): int
    {
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Database execute failed: " . $e->getMessage() . " Query: " . $sql);
            throw new Exception("Database execute failed.");
        }
    }
}