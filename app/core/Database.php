<?php

/**
 * Happy Paws Database Handler
 *
 * Creates one reusable PDO connection and provides methods
 * for prepared SQL queries.
 *
 * The Singleton pattern ensures that only one database
 * connection is created during the request.
 */
class Database
{
    /**
     * Store the single Database instance.
     */
    private static $instance = null;

    /**
     * Database configuration values.
     */
    private $host;
    private $port;
    private $user;
    private $pass;
    private $dbname;

    /**
     * Store the PDO database connection.
     */
    private $dbh;

    /**
     * Store the prepared PDO statement.
     */
    private $stmt;

    /**
     * Store the latest database connection error.
     */
    private $error;

    /**
     * Create the database connection.
     *
     * The constructor is private because this class
     * uses the Singleton pattern.
     */
    private function __construct()
    {
        // Read database settings from config.php.
        $this->host = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
        $this->port = defined('DB_PORT') ? DB_PORT : '3306';
        $this->user = defined('DB_USER') ? DB_USER : 'root';
        $this->pass = defined('DB_PASS') ? DB_PASS : '';
        $this->dbname = defined('DB_NAME') ? DB_NAME : 'happy_paws_db';

        // Configure PDO database behaviour.
        $options = [
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        /*
         * Attempt 1:
         * Connect using the configured host and port.
         */
        try {
            $dsn = 'mysql:host=' . $this->host .
                   ';port=' . $this->port .
                   ';dbname=' . $this->dbname .
                   ';charset=utf8mb4';

            $this->dbh = new PDO(
                $dsn,
                $this->user,
                $this->pass,
                $options
            );

            return;
        } catch (PDOException $exception) {
            $this->error = $exception->getMessage();
        }

        /*
         * Attempt 2:
         * Try localhost when 127.0.0.1 fails, or try
         * 127.0.0.1 when localhost fails.
         */
        try {
            $fallbackHost = ($this->host === '127.0.0.1')
                ? 'localhost'
                : '127.0.0.1';

            $dsn = 'mysql:host=' . $fallbackHost .
                   ';port=' . $this->port .
                   ';dbname=' . $this->dbname .
                   ';charset=utf8mb4';

            $this->dbh = new PDO(
                $dsn,
                $this->user,
                $this->pass,
                $options
            );

            return;
        } catch (PDOException $exception) {
            $this->error = $exception->getMessage();
        }

        /*
         * Attempt 3:
         * Use the standard macOS XAMPP MySQL socket when
         * the project is running on macOS.
         */
        $xamppSocket =
            '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';

        if (file_exists($xamppSocket)) {
            try {
                $dsn = 'mysql:unix_socket=' . $xamppSocket .
                       ';dbname=' . $this->dbname .
                       ';charset=utf8mb4';

                $this->dbh = new PDO(
                    $dsn,
                    $this->user,
                    $this->pass,
                    $options
                );

                return;
            } catch (PDOException $exception) {
                $this->error = $exception->getMessage();
            }
        }

        // Stop execution when every connection attempt fails.
        http_response_code(500);

        die(
            '<div style="font-family: sans-serif; padding: 20px; ' .
            'background: #fee2e2; border-left: 5px solid #ef4444; ' .
            'margin: 20px; border-radius: 6px;">' .
            '<h3>Database Connection Failed</h3>' .
            '<p>' .
            htmlspecialchars(
                $this->error ?? 'Unknown database error',
                ENT_QUOTES,
                'UTF-8'
            ) .
            '</p>' .
            '<p><em>Please ensure MySQL is running in XAMPP ' .
            'and the database configuration is correct.</em></p>' .
            '</div>'
        );
    }

    /**
     * Return the shared Database instance.
     *
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Prepare an SQL statement.
     *
     * @param string $sql SQL query
     * @return Database
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);

        return $this;
    }

    /**
     * Bind a value to a named or numbered parameter.
     *
     * @param string|int $parameter Parameter identifier
     * @param mixed $value Value that should be bound
     * @param int|null $type PDO parameter type
     * @return Database
     */
    public function bind($parameter, $value, $type = null)
    {
        // Automatically detect the PDO parameter type.
        if ($type === null) {
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif ($value === null) {
                $type = PDO::PARAM_NULL;
            } else {
                $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue(
            $parameter,
            $value,
            $type
        );

        return $this;
    }

    /**
     * Execute the prepared SQL statement.
     *
     * @return bool
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Execute the statement and return all records.
     *
     * @return array
     */
    public function resultSet()
    {
        $this->execute();

        return $this->stmt->fetchAll();
    }

    /**
     * Execute the statement and return one record.
     *
     * @return object|false
     */
    public function single()
    {
        $this->execute();

        return $this->stmt->fetch();
    }

    /**
     * Return the number of affected rows.
     *
     * @return int
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Return the ID created by the latest INSERT query.
     *
     * @return string|false
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * Return the PDO connection for transactions
     * or other advanced database operations.
     *
     * @return PDO
     */
    public function getConnection()
    {
        return $this->dbh;
    }

    /**
     * Prevent cloning the Singleton object.
     */
    private function __clone()
    {
    }

    /**
     * Prevent unserializing the Singleton object.
     */
    public function __wakeup()
    {
        throw new Exception(
            'Cannot unserialize the database connection.'
        );
    }
}