<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/17/2018
 * Time: 3:03 PM
 */

namespace Quiz\Controllers;


use Quiz\Models\QuizModel;
use Quiz\Repositories\QuestionDatabaseRepository;
use Quiz\Repositories\QuizDataBaseRepository;

class AjaxQuizController extends BaseAjaxController
{
    /**
     * @var QuizDataBaseRepository
     */
    private $quizRepo;
    private $questionRepository;
    private $questionNumber;

    public function __construct()
    {
        $this->quizRepo = new QuizDataBaseRepository();
        $this->questionRepository = new QuestionDatabaseRepository();
    }

    public function saveQuizzesAction()
    {
        $quizModel = new QuizModel();
        $quizModel->name = $_POST["quizName"];
        $this->quizRepo->save($quizModel);
    }

    public function getQuizzesAction()
    {
        $quizzes = $this->quizRepo->all();

        return $quizzes;

    }

    public function getQuestionsAction()
    {
        session_start();

        $quizId = $_POST["quizId"];
        $condition["quiz_id"] = $quizId;
        $select = [];
        $questions = $this->questionRepository->all($condition, $select);
        $_POST["questionCount"] = count($questions);
        return $questions;
    }

    public function getNextQuestionAction()
    {
        $quizId = $_POST["quizId"];

        $_SESSION =

        $condition["quiz_id"] = $quizId;
        $condition["question_no"] = $_SESSION["question_no"];

    }
}