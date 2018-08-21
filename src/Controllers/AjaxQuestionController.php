<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/19/2018
 * Time: 12:37 PM
 */

namespace Quiz\Controllers;


use Quiz\Models\QuestionModel;
use Quiz\Repositories\QuestionDatabaseRepository;

class AjaxQuestionController extends BaseAjaxController
{
    private $questionRepository;

    public function __construct()
    {
        $this->questionRepository = new QuestionDatabaseRepository();
    }

    public function addQuestionAction()
    {
        $name = $_POST["questionName"];
        $quizId = $_POST["quizId"];
        $questionModel = new QuestionModel();
        $questionModel->quizId = $quizId;
        $questionModel->question = $name;
        $atributes = $this->questionRepository->save($questionModel);

        return $atributes;
    }

    public function getQuestionsAction()
    {
        $quizId = $_POST["quizId"];
        $condition["quiz_id"] = $quizId;
        $select = [];
        $questions = $this->questionRepository->all($condition, $select);

        $_POST["questionCount"] = count($questions);

        return $questions;
    }


}