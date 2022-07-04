<?php

namespace models;

use models\database\DatabaseField;
use models\database\DatabaseModel;

class Role extends DatabaseModel
{
    private string $name;
    private array $permissions;


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
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }

    public function setPermissionsFromJSON(string $json) : void
    {
        $this->permissions = json_decode($json);
    }

    public function getPermissionsJSON() : string
    {
        return json_encode($this->permissions);
    }


    protected static function getTableName(): string
    {
        return 'roles';
    }

    protected static function getFields(): array
    {
        return [
            'name' => new DatabaseField('setName', 'getName', DatabaseField::TYPE_STRING),
            'permissions' => new DatabaseField('setPermissionsFromJSON', 'getPermissionsJSON', DatabaseField::TYPE_STRING)
        ];
    }
}