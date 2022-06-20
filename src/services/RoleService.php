<?php


namespace services;


use exceptions\DbQueryException;
use models\Role;

class RoleService
{

    private const TABLE_NAME = 'roles';

    /**
     * @throws DbQueryException
     */
    public static function getRoleByID(int $id) : Role | bool
    {
        $db = Database::getInst();
        try {
            $roles = $db->execute('SELECT * FROM `' . self::TABLE_NAME . '` WHERE id = :id', [':id' => $id]);
            if (!empty($roles)) {
                $role = new Role($roles[0]['name'], json_decode($roles[0]['permissions'], true));
                $role->setId($roles[0]['id']);
                return $role;
            }
        } catch (DbQueryException $ex) {
            if (strpos($ex->getMessage(), 'exists') > 0 && strpos($ex->getMessage(), self::TABLE_NAME) > 0)
                self::createTable();
            else
                throw $ex;
        }
        return false;
    }

    /**
     * @throws \exceptions\DbQueryException
     */
    private static function createTable() : void
    {
        $db = Database::getInst();
        $db->execute('CREATE TABLE IF NOT EXISTS `' . self::TABLE_NAME .
            '` (`id` SERIAL, `name` VARCHAR(50), `permissions` VARCHAR(255), PRIMARY KEY(`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $db->execute('INSERT INTO `' . self::TABLE_NAME . '` VALUE (1, "Администратор", "[0]")');
    }
}