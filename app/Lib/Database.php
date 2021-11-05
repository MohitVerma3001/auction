<?php
namespace App\Lib;
use PDO;
use PDOException;
use ReflectionClass;
use ReflectionException;
/**
 *class Database
 * @package App\Lib
 */
Class Database
{
    /**
     * @var Database
     */
    private static $databaseObj;
    /**
     * @var PDO
     */
    private $connection;

    /**
     *Returns a Database object using singleton
     * @return Database
     */
    public static function getConnection(): Database
    {
        if (!self::$databaseObj)
            self::$databaseObj = new self();
        return self::$databaseObj;
    }

    /**
     *Database constructor
     */
    private function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Logger::getLogger()->critical("could not create DB connection: ", ['exception' => $e]);
            die();
        }
    }

    /**
     * Execute an SQL statement and return its results
     * @param string $sql
     * @param string|array $bindVal
     * @param bool $retStmt
     * @return bool|\PDOStatement
     */
    public function sqlQuery(string $sql, $bindVal = null, bool $retStmt = false)
    {
        try {
            $statement = $this->connection->prepare($sql);
            if (is_array($bindVal)) {
                $result = $statement->execute($bindVal);
            } else {
                $result = $statement->execute();
            }
            if ($retStmt) {
                return $statement;
            } else {
                return $result;
            }
        } catch (PDOException $e) {
            Logger::getLogger()->critical("could not execute query : ", ['exception' => $e]);
            die();
        }
    }

    /**
     *Execute an SQL statement and return an array of objects
     * @param string $sql
     * @param string $class
     * @param string|array $bindVal
     * @return array
     */
    public function fetch(string $sql, string $class, $bindVal = null): array
    {
        $statement = $this->sqlQuery($sql, $bindVal, true);
        if ($statement->rowCount() == 0) {
            return [];
        }
        try {
            $reflect = new ReflectionClass ($class);
            if ($reflect->getConstructor() == null) {
                $ctor_args = [];
            } else {
                $num = count($reflect->getConstructor()->getParameters());
                $ctor_args = array_fill(0, $num, null);
            }
            return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class, $ctor_args);
        } catch (RefllectiomException $e) {
            Logger::getLogger()->critical("Reflection error : ", ['exception' => $e]);
            die();
        }
    }

    /**
     * Return the AUTO_INCREMENT value on last operation
     * @return string
     */
    public function lastInsertId(): string
    {
        $id = $this->connection->lastInsertId();
        return $id;
    }

    /**
     *Execute an SQL statement and return number of rows returned
     * @param string $sql
     * @param string|array $bindVal
     * @return int
     */
    public function rowCount(string $sql, $bindVal = null): int {
        $statement = $this->sqlQuery($sql, $bindVal, true);
        return $statement->rowCount();
    }
}


