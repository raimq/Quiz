<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/16/2018
 * Time: 1:26 PM
 */

namespace Quiz\Interfaces;


interface RepositoryInterface
{
    public static function modelName(): string ;

    public static function getTableName(): string;

}