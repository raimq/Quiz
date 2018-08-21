<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/16/2018
 * Time: 12:42 PM
 */

namespace Quiz\Repositories;


use Quiz\Models\AnswerModel;

class AnswerDataBaseRepository extends BaseRepository
{


    public static function modelName(): string
    {
        return AnswerModel::class;
    }

    public static function getTableName(): string
    {
        return 'answers';
    }
}