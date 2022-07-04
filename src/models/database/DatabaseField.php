<?php


namespace models\database;


class DatabaseField
{
    private string $modelSetterName, $modelGetterName, $defaultValue;
    private int $key, $type;
    private bool $null;

    public const NO_KEY = 0;
    public const PRIMARY_KEY = 1;
    public const UNIQUE_KEY = 2;

    public const TYPE_SERIAL = 1;
    public const TYPE_INT = 2;
    public const TYPE_BIGINT = 3;
    public const TYPE_FLOAT = 4;
    public const TYPE_DOUBLE = 5;

    public const TYPE_STRING = 11;
    public const TYPE_TEXT = 12;

    public const TYPE_DATE = 21;
    public const TYPE_TIME = 22;
    public const TYPE_DATETIME = 23;

    /**
     * DatabaseField constructor.
     * @param string $modelSetterName
     * @param string $modelGetterName
     * @param string $defaultValue
     * @param int $key
     * @param int $type
     * @param bool $null
     */
    public function __construct(
        string $modelSetterName,
        string $modelGetterName,
        int $type,
        string $defaultValue = 'NULL',
        int $key = self::NO_KEY,
        bool $null = true)
    {
        $this->modelSetterName = $modelSetterName;
        $this->modelGetterName = $modelGetterName;
        $this->defaultValue = $defaultValue;
        $this->key = $key;
        $this->type = $type;
        $this->null = $null;
    }

    /**
     * @return string
     */
    public function getModelSetterName(): string
    {
        return $this->modelSetterName;
    }

    /**
     * @return string
     */
    public function getModelGetterName(): string
    {
        return $this->modelGetterName;
    }

    /**
     * @return string
     */
    public function getDefaultValue(): string
    {
        return $this->defaultValue;
    }

    /**
     * @return int
     */
    public function getKey(): int
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->null;
    }
}