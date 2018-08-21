<?php

namespace Quiz\Repositories;


use PDO;
use Quiz\Interfaces\RepositoryInterface;
use Quiz\Models\BaseModel;
use Quiz\MySQL\MysqlConnection;

abstract class BaseRepository implements RepositoryInterface

{
    /** @var MysqlConnection */
    private $connection;


    public function getConnection()
    {

        $this->connection = new MysqlConnection();
        return $this->connection;
    }


    public function getById(int $id)
    {
        return $this->one(['id' => $id]);
    }

    /**
     * @param array $conditions
     * @param array $select
     * @return array
     */
    public function all(array $conditions = [], array $select = []): array
    {
        $dataArray = static::getConnection()->select(static::getTableName(), $conditions, $select);
        $instances = [];
        foreach ($dataArray as $data) {
            $instances[] = static::init($data);
        }
        return $instances;
    }


    public static function init(array $attributes)
    {
        $class = static::modelName();
        $instance = new $class;
        foreach ($attributes as $key => $value) {
            if (property_exists($class, static::getCamelCase($key))) {
                $tempKey = static::getCamelCase($key);
                $instance->$tempKey = $value;
            }
        }
        return $instance;
    }


    /**
     * @param array $attributes
     * @return BaseModel
     */
    public static function initLoaded(array $attributes)
    {
        $instance = static::init($attributes);
        $instance->isNew = false;
        return $instance;
    }


    /**
     * @param array $conditions
     * @return BaseModel
     */
    public function one(array $conditions = [])
    {
        $data = static::getConnection()->select(static::getTableName(), $conditions)[0] ?? [];
        if (!$data) {
            return null;
        }
        return static::initLoaded($data);
    }

    public static function getPrimaryKey(): string
    {
        return 'id';
    }

    /**
     * @param BaseModel $model
     * @return array
     */
    public function save($model): array
    {
        $connection = static::getConnection();
        if ($model->isNew) {
            $atributes = $connection->insert(static::getTableName(), static::getPrimaryKey(),
                $this->getAttributes($model));
            return $atributes;
        }
        return $connection->update(static::getTableName(), static::getPrimaryKey(), $this->getAttributes($model));
    }

    public function getAttributes($model): array
    {
        if (!$model->attributes) {
            $model = $this->prepareAttributes($model);
        }
        return $model->attributes;
    }

    protected function prepareAttributes($model)
    {
        $columns = static::getConnection()->fetchColumns(static::getTableName());
        $attributes = [];
        foreach ($columns as $column) {
            if (property_exists(static::modelName(), $this->getCamelCase($column))) {
                $tempColumn = $this->getCamelCase($column);
                $attributes[$column] = $model->{$tempColumn};
            }
        }
        $model->attributes = $attributes;
        return $model;
    }

    public function create(array $attributes = [])
    {
        return $this->init($attributes);
    }

    public static function getCamelCase($input, $separator = '_')
    {
        return str_replace($separator, '', lcfirst(ucwords($input, $separator)));
    }

    public static function getSnakeCase($string)
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }


}