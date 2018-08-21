<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/19/2018
 * Time: 9:11 PM
 */

namespace Quiz\Controllers;


use Quiz\Models\UserAnswerModel;
use Quiz\Repositories\UserAnswerDataBaseRepository;

class AjaxUserAnswerController extends BaseAjaxController
{
    private $userAnswerRepo;

    public function __construct()
    {
        $this->userAnswerRepo = new UserAnswerDataBaseRepository();

    }

    public function saveUserAnswerAction()
    {
        $quizId = $_POST["quizId"];
        $questionId = $_POST["questionId"];
        $answerId = $_POST["answerId"];
        $userId = $_POST["userId"];
        $userAnswerModel = new UserAnswerModel();
        $userAnswerModel->questionId = $questionId;
        $userAnswerModel->quizId = $quizId;;
        $userAnswerModel->answerId = $answerId;
        $userAnswerModel->userId = $userId;
        $data = $this->userAnswerRepo->save($userAnswerModel);

        return $data;
    }

    public function getUserAnswersAction()
    {
        $userId = $_POST["userId"];
        $condition["user_id"] = $userId;
        $userAnswers = $this->userAnswerRepo->all($condition);

        $_POST["userAnswerCount"] = count($userAnswers);

        return $userAnswers;
    }


}