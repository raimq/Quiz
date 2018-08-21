<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/16/2018
 * Time: 3:46 PM
 */

namespace Quiz\Interfaces;


use phpDocumentor\Reflection\Types\Boolean;

interface ConnectionInterface
{


    public function select(string $table, array  $conditions = [], array $select = []);

    public function insert(string $table, string $primaryKey, array $attributes);

    public function update(string $table, string $primaryKey, array $attributes):bool;

    public function fetchColumns(string $table): array;



}