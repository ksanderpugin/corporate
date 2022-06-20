<?php

namespace models;

class Role
{
    private int $id;
    private string $name;
    private array $permissions;

    /**
     * Role constructor.
     * @param string $name
     * @param array $permissions
     */
    public function __construct(string $name, array $permissions)
    {
        $this->name = $name;
        $this->permissions = $permissions;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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


}