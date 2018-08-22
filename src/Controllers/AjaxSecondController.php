<?php

namespace Quiz\Controllers;

use Quiz\Services\QuizServiceTwo;

class AjaxSecondController extends BaseAjaxController
{
    /** @var QuizServiceTwo */
    protected $quizService;

    public function __construct(QuizServiceTwo $quizService)
    {
        if (!session_id()) {
            session_start();
        }
        $this->quizService = $quizService;
    }

    public function saveUserAction()
    {
        $name = $_POST["name"];
        $user_id = $this->quizService->saveUser($name);
        $_SESSION["userId"] = $user_id;
        return $user_id;
    }

    public function getAllQuizzesAction()
    {
        return $this->quizService->getAllQuezzes();
    }

    public function indexAction()
    {
        return [
            'name' => '',
            'quizes' => [
                [
                    'id' => 1,
                    'name' => 'Programming'
                ],
            ]
        ];
    }

    public function startAction()
    {
        $quizId = $_POST["quizId"];
        $name = $_POST['name'];
        $_SESSION['questionIndex'] = 0;
        $userId = $this->quizService->saveUser($name);
        $_SESSION['userId'] = $userId;

        return $this->getQuestion($quizId);
    }

    public function testArea()
    {
        $this->quizService->getCorrectAnswers(358);

    }

    public function answerAction()
    {
        $quizId = $_POST["quizId"];
        $answerId = $_POST["answerId"];
        $userId = $_SESSION['userId'];
        $this->quizService->saveUserAnswer($answerId, $userId);

        $index = isset($_SESSION['questionIndex']) ? (int)$_SESSION['questionIndex'] : 0;
        $index++;
        $_SESSION['questionIndex'] = $index;

        return $this->getQuestion($quizId, $index);
    }

    public function getQuestion($quizId, int $index = 0)
    {
        $questions = $this->quizService->getQuestion($quizId);

        if (!isset($questions[$index])) {

            $result = $this->quizService->getCorrectAnswers($_SESSION['userId']);
            $correctAnswers = $result['correctAnswers'];
            $totalAnswers = $result['totalAnswers'];

            $userId = $_SESSION['userId'];

            $score = 0;

            if ($correctAnswers != 0) {
                $score = ($correctAnswers / $totalAnswers) * 100;
            }

            $this->quizService->postScore($userId, $quizId, $score);

            return "$correctAnswers no $totalAnswers";
        }
        return $questions[$index];
    }
}