<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/19/2018
 * Time: 12:37 PM
 */

namespace Quiz\Controllers;

use Quiz\Models\AnswerModel;
use Quiz\Repositories\AnswerDataBaseRepository;

class AjaxAnswerController extends BaseAjaxController
{
    private $answerRepository;

    public function __construct()
    {
        $this->answerRepository = new AnswerDataBaseRepository();
    }

    public function addAnswersAction()
    {
        $answer = new AnswerModel();
        $answer->questionId = $_POST["questionId"];
        $answer->answer = $_POST["answer"];
        $answer->isCorrect = $_POST["isCorrect"];

        $this->answerRepository->save($answer);
    }

    public function getAnswersAction()
    {
        $questionId = $_POST["questionId"];
        $condition["question_id"] = $questionId;
        $select[] = "answer";
        $select[] = "is_correct";
        $answers = $this->answerRepository->all($condition, $select);
        return $answers;
    }
}