<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/16/2018
 * Time: 12:42 PM
 */

namespace Quiz\Repositories;


use Quiz\Models\QuestionModel;

class QuestionDatabaseRepository extends BaseRepository
{


    public function insertQuestion(QuestionModel $model)
    {

        $this->save($model);
    }

    public function testAddQuestion(QuestionModel $questionModel)
    {
        $this->save($questionModel);
    }

    public static function modelName(): string
    {
        return QuestionModel::class;
    }

    public static function getTableName(): string
    {
        return 'questions';
    }
}