<?php


namespace models\database;


class Database
{
    private static Database $inst;
    private static string $type = '';
    private \PDO $connection;
    private static bool $connect = false;

    /**
     * Database constructor.
     * @throws \exceptions\DbNoConnectException
     */
    private function __construct()
    {
        if (strlen(self::$type) < 1) self::$type = 'mysql';
        $this->connect();
    }


    /**
     * @throws \exceptions\DbNoConnectException
     */
    private function connect() {
        try {
            $this->connection = new \PDO(
                self::$type.':host=' . \settings\DatabaseConfig::DB_HOST . ';dbname=' . \settings\DatabaseConfig::DB_NAME,
                \settings\DatabaseConfig::DB_USER,
                \settings\DatabaseConfig::DB_PASS
            );

            $this->connection->exec('set names utf8');

            self::$connect = true;
        } catch (\PDOException $ex) {
            self::$connect = false;
            throw new \exceptions\DbNoConnectException('Database connect error: ' . $ex->getMessage());
        }
    }

    public static function getInst() : Database
    {
        if (!self::$connect) self::$inst = new self();
        return self::$inst;
    }

    /**
     * @param string $query
     * @param array $params
     * @return bool|int|array
     * @throws \exceptions\DbQueryException
     */
    public function execute(string $query, array $params = []) : bool | int | array
    {
        if (!self::$connect) return false;
        try {
            $stm = $this->connection->prepare($query);
            $respond = $stm->execute($params);
            if ($respond !== false) {
                preg_match('~^select(.*)$~i', $query, $matches);
                if (!empty($matches)) return $stm->fetchAll(\PDO::FETCH_ASSOC);
                preg_match('~^insert(.*)$~i', $query, $matches);
                if (!empty($matches)) return $this->connection->lastInsertId();
                return true;
            } else {
                throw new \exceptions\DbQueryException('Query error: ' . $this->connection->errorInfo()[2] . PHP_EOL . 'Query: ' . $query);
            }
        } catch (\PDOException $ex) {
            throw new \exceptions\DbQueryException('Query error: ' . $ex->getMessage() . PHP_EOL . 'Query: ' . $query);
        }
    }
}