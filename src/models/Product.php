<?php


class Product
{
    private int $id, $weightOfPacking, $balance;
    private string $fullName, $shortName, $storageConditions, $storageTime, $standard;
    private bool $weight;

    /**
     * Product constructor.
     * @param int $weightOfPacking
     * @param int $balance
     * @param string $fullName
     * @param string $shortName
     * @param string $storageConditions
     * @param string $storageTime
     * @param string $standard
     * @param bool $weight
     */
    public function __construct(int $weightOfPacking, int $balance, string $fullName, string $shortName, string $storageConditions, string $storageTime, string $standard, bool $weight)
    {
        $this->weightOfPacking = $weightOfPacking;
        $this->balance = $balance;
        $this->fullName = $fullName;
        $this->shortName = $shortName;
        $this->storageConditions = $storageConditions;
        $this->storageTime = $storageTime;
        $this->standard = $standard;
        $this->weight = $weight;
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
     * @return int
     */
    public function getWeightOfPacking(): int
    {
        return $this->weightOfPacking;
    }

    /**
     * @param int $weightOfPacking
     */
    public function setWeightOfPacking(int $weightOfPacking): void
    {
        $this->weightOfPacking = $weightOfPacking;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @param int $balance
     */
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName): void
    {
        $this->shortName = $shortName;
    }

    /**
     * @return string
     */
    public function getStorageConditions(): string
    {
        return $this->storageConditions;
    }

    /**
     * @param string $storageConditions
     */
    public function setStorageConditions(string $storageConditions): void
    {
        $this->storageConditions = $storageConditions;
    }

    /**
     * @return string
     */
    public function getStorageTime(): string
    {
        return $this->storageTime;
    }

    /**
     * @param string $storageTime
     */
    public function setStorageTime(string $storageTime): void
    {
        $this->storageTime = $storageTime;
    }

    /**
     * @return string
     */
    public function getStandard(): string
    {
        return $this->standard;
    }

    /**
     * @param string $standard
     */
    public function setStandard(string $standard): void
    {
        $this->standard = $standard;
    }

    /**
     * @return bool
     */
    public function isWeight(): bool
    {
        return $this->weight;
    }

    /**
     * @param bool $weight
     */
    public function setWeight(bool $weight): void
    {
        $this->weight = $weight;
    }


}