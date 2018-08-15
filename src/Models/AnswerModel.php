<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/14/2018
 * Time: 10:25 AM
 */

namespace Quiz\Models;

class AnswerModel
{
    /** @var int */
    public $id;

    /** @var string */
    public $answer;

    /** @var int */
    public $questionId;

    /** @var boolean */
    public $isCorrect;

}