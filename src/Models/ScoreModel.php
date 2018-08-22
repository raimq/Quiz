<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/14/2018
 * Time: 10:28 AM
 */

namespace Quiz\Models;

class ScoreModel extends BaseModel
{
    /** @var int */
    public $id;
    /**  @var int */
    public $userId;
    /** @var int */
    public $quizId;
    /** @var int */
    public $score;

}