<?php

namespace models\database;


use exceptions\DatabaseModelException;
use exceptions\DbQueryException;

abstract class DatabaseModel
{
    protected int $id;

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
     * @throws DatabaseModelException
     * @throws DbQueryException
     */
    public static function findAll() : array
    {
        $result = [];

        $db = Database::getInst();
        try {
            $respond = $db->execute('SELECT * FROM `' . static::getTableName() . '`');
            foreach ($respond as $row) {
                $item = new static();
                $item->setId($row['id']);
                foreach (static::getFields() as $fieldName => $fieldInfo) {
                    $setter = $fieldInfo->getModelSetterName();
                    $item->$setter($row[$fieldName]);
                }
                $result[] = $item;
            }
        } catch (DbQueryException $ex) {
            if (self::isNotExists($ex->getMessage()))
                self::createTable();
            else
                throw $ex;
        }

        return $result;
    }

    /**
     * @param int $id
     * @return static|null
     * @throws DbQueryException
     * @throws DatabaseModelException
     */
    public static function getById(int $id) : static | null
    {
        return static::getByFieldName('id', $id);
    }

    /**
     * @throws DbQueryException
     * @throws DatabaseModelException
     */
    public static function getByFieldName(string $fieldName, mixed $value): static | null
    {
        if (isset(static::getFields()[$fieldName]) || $fieldName == 'id') {
            try {
                $row = Database::getInst()->execute('SELECT * FROM `' . static::getTableName() . '` WHERE `' .
                    $fieldName . '` = :' . $fieldName, [':'.$fieldName => $value]);
                if (empty($row)) return null;

                $objArr = $row[0];
                $obj = new static();
                $obj->setId($objArr['id']);
                foreach (static::getFields() as $fieldName => $fileInfo) {
                    $setter = $fileInfo->getModelSetterName();
                    $obj->$setter($objArr[$fieldName]);
                }

                return $obj;
            } catch (DbQueryException $ex) {
                if (self::isNotExists($ex->getMessage())) self::createTable();
                else throw $ex;
            }
        }

        return null;
    }

    /**
     * @throws DbQueryException
     * @throws DatabaseModelException
     */
    public function save() : void
    {
        $query = '';
        $params = [];
        $arrForUpdate = [];
        $arrForInsert = []; $arrValForInsert = [];
        foreach (static::getFields() as $filedName => $filedInfo) {
            if ($filedName != 'id') {
                $getter = $filedInfo->getModelGetterName();
                $params[':' . $filedName] = $this->$getter();
                $arrForUpdate[] = '`' . $filedName . '` = :' . $filedName;
                $arrForInsert[] = '`' . $filedName . '`';
                $arrValForInsert[] = ':' . $filedName;
            }
        }
        if (isset($this->id)) {
            $query = 'UPDATE `' . static::getTableName() . '` SET ' . implode(', ', $arrForUpdate) . ' WHERE `id` = :id';
            $params['id'] = $this->id;
        }
        else {
            $query = 'INSERT INTO `' . static::getTableName() . '` (' . implode(', ', $arrForInsert) . ') VALUE (' .
                implode(', ', $arrValForInsert) . ')';
        }
        try {
            $dbResult = Database::getInst()->execute($query, $params);
            if (is_int($dbResult))
                $this->id = $dbResult;
        } catch (DbQueryException $ex) {
            if (self::isNotExists($ex->getMessage())) {
                self::createTable();
                $this->save();
            }
            else throw $ex;
        }
    }

    private static function isNotExists(string $mess) : bool
    {
        return strpos($mess, 'exist') > 0 && strpos($mess, static::getTableName()) > 0;
    }

    /**
     * @throws DatabaseModelException
     * @throws DbQueryException
     */
    private static function createTable()
    {
        $fields = static::getFields();
        if (!is_array($fields) || empty($fields))
            throw new DatabaseModelException('Function `getFields` must return array of fields');

        $tableFields = [];
        $idNotExists = true;
        foreach ($fields as $fieldName => $fieldInfo) {

            if (get_class($fieldInfo) != DatabaseField::class)
                throw new DatabaseModelException('Function `getFields` must return array of DatabaseField. Your class is ' . get_class($field));

            if ($fieldInfo->getModelSetterName() == 'setId')
                $idNotExists = false;

            $fieldCommand = '`' . $fieldName . '`';
            $fieldCommand .= match ($fieldInfo->getType()) {
                DatabaseField::TYPE_SERIAL => ' SERIAL',
                DatabaseField::TYPE_INT => ' INT(10)',
                DatabaseField::TYPE_BIGINT => ' BIGINT',
                DatabaseField::TYPE_FLOAT => ' FLOAT',
                DatabaseField::TYPE_DOUBLE => ' DOUBLE',
                DatabaseField::TYPE_STRING => ' VARCHAR(255)',
                DatabaseField::TYPE_TEXT => ' TEXT',
                DatabaseField::TYPE_DATE => ' DATE',
                DatabaseField::TYPE_TIME => ' TIME',
                DatabaseField::TYPE_DATETIME => ' DATETIME'
            };

            if ($fieldInfo->getType() != DatabaseField::TYPE_SERIAL) {
                if (!$fieldInfo->isNull()) {
                    $fieldCommand .= ' NOT NULL';
                    if ($fieldInfo->getDefaultValue() != 'NULL')
                        $fieldCommand .= ' DEFAULT "' . strtr($fieldInfo->getDefaultValue(), ['"' => '\\"']) . '"';
                } else if ($fieldInfo->getDefaultValue() != 'NULL')
                    $fieldCommand .= ' DEFAULT "' . strtr($fieldInfo->getDefaultValue(), ['"' => '\\"']) . '"';
                else $fieldCommand .= ' DEFAULT NULL';
            }

            $fieldCommand .= match ($fieldInfo->getKey()) {
                DatabaseField::PRIMARY_KEY => ' PRIMARY KEY',
                DatabaseField::UNIQUE_KEY => ' UNIQUE',
                DatabaseField::NO_KEY => ''
            };

            $tableFields[] = $fieldCommand;
        }

        $query = 'CREATE TABLE IF NOT EXISTS `' . static::getTableName() . '` (';
        if ($idNotExists)
            $query .= '`id` SERIAL PRIMARY KEY, ';
        $c = count($tableFields);
        for ($i=0; $i<$c;) {
            $query .= $tableFields[$i];
            if (++$i < $c) $query .= ', ';
        }
        $query .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        Database::getInst()->execute($query);
    }

    abstract protected static function getTableName() : string;
    abstract protected static function getFields() : array;
}