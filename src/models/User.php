<?php

namespace models;

use models\database\DatabaseField;
use models\database\DatabaseModel;

class User extends DatabaseModel
{
    private string $name, $pin, $key = '';
    private \models\Role $role;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPin(): string
    {
        return $this->pin;
    }

    /**
     * @param string $pin
     */
    public function setPin(string $pin): void
    {
        $this->pin = $pin;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return int
     */
    public function getRoleId() : int
    {
        return $this->role->getId();
    }

    /**
     * @throws \exceptions\DbQueryException
     * @throws \exceptions\DatabaseModelException
     * @param int $id
     */
    public function setRoleFromId(int $id): void
    {
        $role = Role::getById($id);
        if (!is_null($role))
            $this->role = $role;
    }


    protected static function getTableName(): string
    {
        return 'users';
    }

    protected static function getFields(): array
    {
        return [
            'name' => new DatabaseField('setName', 'getName', DatabaseField::TYPE_STRING),
            'pin' => new DatabaseField('setPin', 'getPin', DatabaseField::TYPE_STRING),
            'key' => new DatabaseField('setKey', 'getKey', DatabaseField::TYPE_STRING),
            'role_id' => new DatabaseField('setRoleFromId', 'getRoleId', DatabaseField::TYPE_INT)
        ];
    }
}