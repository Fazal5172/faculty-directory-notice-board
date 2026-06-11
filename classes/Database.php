<?php
/**
 * Database Class
 * Singleton pattern — one connection shared across the application.
 * All queries use prepared statements to prevent SQL injection.
 */
class Database
{
    private static ?Database $instance = null;
    private mysqli $connection;

    private function __construct()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            // Log the error instead of exposing it to the user
            error_log('Database connection failed: ' . $this->connection->connect_error);
            die('A database error occurred. Please contact the administrator.');
        }

        $this->connection->set_charset('utf8mb4');
    }

    /**
     * Get the single Database instance
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Get raw mysqli connection
     */
    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    /**
     * Execute a prepared SELECT query and return all rows.
     *
     * @param string $sql   SQL with ? placeholders
     * @param string $types Bind types: s=string, i=int, d=double, b=blob
     * @param array  $params Values to bind
     * @return array
     */
    public function select(string $sql, string $types = '', array $params = []): array
    {
        $stmt = $this->prepare($sql, $types, $params);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    /**
     * Execute a prepared SELECT and return a single row.
     */
    public function selectOne(string $sql, string $types = '', array $params = []): ?array
    {
        $rows = $this->select($sql, $types, $params);
        return $rows[0] ?? null;
    }

    /**
     * Execute a prepared INSERT / UPDATE / DELETE.
     * Returns the number of affected rows.
     */
    public function execute(string $sql, string $types = '', array $params = []): int
    {
        $stmt = $this->prepare($sql, $types, $params);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected;
    }

    /**
     * Returns the last auto-increment ID after an INSERT.
     */
    public function lastInsertId(): int
    {
        return $this->connection->insert_id;
    }

    /**
     * Internal helper: prepare and bind a statement.
     */
    private function prepare(string $sql, string $types, array $params): mysqli_stmt
    {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            error_log('Prepare failed: ' . $this->connection->error . ' | SQL: ' . $sql);
            die('A query error occurred.');
        }
        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }
        // NOTE: do NOT call $stmt->execute() here.
        // The callers (select, execute) each call it themselves.
        return $stmt;
    }

    // Prevent cloning and unserialization of the singleton
    private function __clone() {}
    public function __wakeup() { throw new \Exception('Cannot unserialize singleton.'); }
}
