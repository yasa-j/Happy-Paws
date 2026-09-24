<?php
/**
 * =======================================================================
 * Happy Paws - PDO Database Handler (Singleton Pattern)
 * =======================================================================
 * 
 * Manages database connectivity, prepared SQL statements, parameter
 * binding, and query execution using PHP Data Objects (PDO).
 * 
 * Design Pattern: Singleton ensures a single database connection instance
 * is reused across the entire request lifecycle.
 * =======================================================================
 */

class Database {
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private static $instance = null;
    private $dbh;
    private $stmt;
    private $error;

    /**
     * Private constructor to prevent direct instantiation from external code.
     * Establishes the PDO connection with resilient fallback.
     */
    private function __construct() {
        $options = [
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        // Attempt 1: Standard Host & Port connection
        try {
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname . ';charset=utf8mb4';
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            return;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

        // Attempt 2: Fallback to localhost if host was 127.0.0.1 or vice-versa
        try {
            $fallbackHost = ($this->host === '127.0.0.1') ? 'localhost' : '127.0.0.1';
            $dsn = 'mysql:host=' . $fallbackHost . ';dbname=' . $this->dbname . ';charset=utf8mb4';
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            return;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

        // Attempt 3: Fallback to macOS XAMPP standard socket path
        $xamppSocket = '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
        if (file_exists($xamppSocket)) {
            try {
                $dsn = 'mysql:unix_socket=' . $xamppSocket . ';dbname=' . $this->dbname . ';charset=utf8mb4';
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
                return;
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
            }
        }

        // If all attempts failed, terminate with informative diagnostic message
        die('<div style="font-family:sans-serif; padding:20px; background:#fee2e2; border-left:5px solid #ef4444; margin:20px; border-radius:6px;">' .
            '<h3>Database Connection Failed</h3>' .
            '<p>' . htmlspecialchars($this->error) . '</p>' .
            '<p><em>Please ensure MySQL is running in XAMPP and the schema has been imported via <code>database/setup.php</code>.</em></p>' .
            '</div>');
    }

    /**
     * Get the single Database instance (Singleton Pattern)
     * 
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Prepare a SQL query statement
     * 
     * @param string $sql SQL query with named or positional parameters
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Bind a value to a parameter in the prepared statement
     * 
     * @param string $param Parameter identifier (e.g. :email)
     * @param mixed $value The value to bind
     * @param int|null $type Optional explicit PDO parameter type
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute the prepared statement
     * 
     * @return bool True on success, false on failure
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Execute statement and return all matching records as an array of objects
     * 
     * @return array
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Execute statement and return a single record as an object
     * 
     * @return object|false
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Get the number of rows affected by the last SQL statement
     * 
     * @return int
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * Get the ID generated by the last INSERT query
     * 
     * @return string
     */
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
}
