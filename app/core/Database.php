<?php

/**
 * Database Connection Class
 *
 * This class creates one shared PDO connection and provides
 * reusable methods for prepared SQL queries.
 */
class Database
{
    /**
     * Store the single Database object.
     */
    private static $instance = null;

    /**
     * Store the PDO database connection.
     */
    private $connection;

    /**
     * Store the prepared PDO statement.
     */
    private $statement;

    /**
     * Create the database connection.
     *
     * The constructor is private because this class
     * uses the Singleton pattern.
     */
    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST .
               ';dbname=' . DB_NAME .
               ';charset=utf8mb4';

        $options = [
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->connection = new PDO(
                $dsn,
                DB_USER,
                DB_PASS,
                $options
            );
        } catch (PDOException $exception) {
            http_response_code(500);

            die(
                'Database connection failed: ' .
                htmlspecialchars($exception->getMessage())
            );
        }
    }

    /**
     * Return the shared Database object.
     *
     * Example:
     * $this->db = Database::getInstance();
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Prepare an SQL query.
     *
     * Example:
     * $this->db->query('SELECT * FROM products');
     */
    public function query($sql)
    {
        $this->statement =
            $this->connection->prepare($sql);

        return $this;
    }

    /**
     * Bind a value to a named or numbered parameter.
     *
     * Example:
     * $this->db->bind(':product_id', $id);
     */
    public function bind($parameter, $value, $type = null)
    {
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

        $this->statement->bindValue(
            $parameter,
            $value,
            $type
        );

        return $this;
    }

    /**
     * Execute the prepared query.
     */
    public function execute()
    {
        return $this->statement->execute();
    }

    /**
     * Return multiple records as objects.
     */
    public function resultSet()
    {
        $this->execute();

        return $this->statement->fetchAll();
    }

    /**
     * Return one record as an object.
     */
    public function single()
    {
        $this->execute();

        return $this->statement->fetch();
    }

    /**
     * Return the number of affected database rows.
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * Return the ID of the last inserted record.
     */
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Return the PDO connection when a transaction is required.
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Prevent cloning the Singleton database object.
     */
    private function __clone()
    {
    }

    /**
     * Prevent unserializing the Singleton database object.
     */
    public function __wakeup()
    {
        throw new Exception(
            'Cannot unserialize the database connection.'
        );
    }
}