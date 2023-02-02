<?php

namespace FilmAPI;

use Exception;
use FilmAPI\Exception\DatabaseConnectException;
use mysqli;

/**
 * Database class which will handle db interactions.
 *
 * @package FilmApi
 */
class Database
{
    protected ?mysqli $con = null;

    /**
     * Keep Database instance
     *
     * @var $instance ?Database Instance of Database.
     */
    private static ?Database $instance = null;

    /**
     * Returns an instance of this class.
     *
     * @return ?Database Database instance.
     */
    public static function getInstance(): ?Database
    {
        if (null === self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Constructor
     *
     * @throws DatabaseConnectException
     */
    public function __construct()
    {
        try {
            $this->con = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB, MYSQL_PORT);
            if (mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new DatabaseConnectException();
        }
    }

    /**
     * Execute select query
     *
     * @param string $query SQL query.
     * @param array $params Params.
     *
     * @return array
     *
     * @throws Exception
     */
    public function select(string $query, array $params = []): array
    {
        $mysqliStmt = $this->exec($query, $params);
        $result = $mysqliStmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $mysqliStmt->close();

        return $result;
    }

    /**
     * Execute sql query
     *
     * @param string $query SQL query.
     * @param array $params Params.
     *
     * @throws Exception
     */
    public function exec(string $query, array $params = [])
    {
        $mysqliStmt = $this->con->prepare($query);

        if (false === $mysqliStmt) {
            throw new Exception("Error! Cannot prepare statement.");
        }

        if (!empty($params)) {
            $mysqliStmt->bind_param(...$params);
        }

        $mysqliStmt->execute();

        return $mysqliStmt;
    }

    /**
     * Escape sql value
     *
     * @param int|string $value Value.
     *
     * @return int|string
     *
     * @throws Exception
     */
    public function escape(int|string $value): int|string
    {
        return mysqli_real_escape_string($this->con, $value);
    }


    /**
     * Get last instert ID
     *
     * @return int|string
     */
    public function lastInsertId(): int|string
    {
        return $this->con->insert_id;
    }
}
