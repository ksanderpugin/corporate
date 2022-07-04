<?php


namespace models;


use models\database\DatabaseField;
use models\database\DatabaseModel;
use services\SecurityService;

class Account extends DatabaseModel
{
    private string $mail, $passHash, $name, $key = 'none', $dateCreate, $telegramChatId = '0';

    private array $terminals = [];

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getPassHash(): string
    {
        return $this->passHash;
    }

    /**
     * @param string $passHash
     */
    public function setPassHash(string $passHash): void
    {
        $this->passHash = $passHash;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->passHash = SecurityService::getPassHash($pass);
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
     * @return string
     */
    public function getDateCreate(): string
    {
        if (isset($this->dateCreate)) return $this->dateCreate;

        return date('Y-m-d H:i:s');
    }

    /**
     * @param string $dateCreate
     */
    public function setDateCreate(string $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return string
     */
    public function getTelegramChatId(): string
    {
        return $this->telegramChatId;
    }

    /**
     * @param string $telegramChatId
     */
    public function setTelegramChatId(string $telegramChatId): void
    {
        $this->telegramChatId = $telegramChatId;
    }


    protected static function getTableName(): string
    {
        return 'accounts';
    }

    protected static function getFields(): array
    {
        return [
            'mail' => new DatabaseField('setMail', 'getMail', DatabaseField::TYPE_STRING, 'NULL', DatabaseField::UNIQUE_KEY, false),
            'pass_hash' => new DatabaseField('setPassHash', 'getPassHash', DatabaseField::TYPE_STRING),
            'name' => new DatabaseField('setName','getName', DatabaseField::TYPE_STRING),
            'key' => new DatabaseField('setKey', 'getKey', DatabaseField::TYPE_STRING),
            'create_date' => new DatabaseField('setDateCreate', 'getDateCreate', DatabaseField::TYPE_DATETIME),
            'telegram_chat_id' => new DatabaseField('setTelegramChatId', 'getTelegramChatId', DatabaseField::TYPE_STRING)
        ];
    }
}