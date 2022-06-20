<?php

namespace services;

use models\User;

class UserService
{

    private const TABLE_NAME = 'users';

    /**
     * @throws \exceptions\DbQueryException
     */
    public static function getAll() : array
    {
        $query = 'SELECT * FROM `' . self::TABLE_NAME . '`';
        try {
            $userArr = Database::getInst()->execute($query);
            $result = [];
            foreach ($userArr as $userInfo)
                $result[] = new User(
                    $userInfo['name'],
                    $userInfo['pin_hash'],
                    \services\RoleService::getRoleByID($userInfo['role_id']),
                    $userInfo['id']
                );
            return $result;
        } catch (\exceptions\DbQueryException $ex) {
            if (strpos($ex->getMessage(), 'exist') > 0 && strpos($ex->getMessage(), self::TABLE_NAME) > 0) {
                self::createTableInDatabase();
            } else {
                throw $ex;
            }
        }

        return [];
    }



    /**
     * @throws \exceptions\DbQueryException
     */
    private static function createTableInDatabase()
    {
        $db = Database::getInst();
        $db->execute('CREATE TABLE IF NOT EXISTS `' . self::TABLE_NAME .
            '` (`id` SERIAL, `name` VARCHAR(100), `pin_hash` CHAR(4), `role_id` SMALLINT UNSIGNED NOT NULL, PRIMARY KEY(`id`))');
    }
}