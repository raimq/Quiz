<?php

namespace Quiz\Services;


use Quiz\Models\BaseModel;
use Quiz\Models\ScoreModel;
use Quiz\Models\UserAnswerModel;
use Quiz\Repositories\AnswerDataBaseRepository;
use Quiz\Repositories\QuestionDatabaseRepository;
use Quiz\Repositories\QuizDataBaseRepository;
use Quiz\Repositories\UserAnswerDataBaseRepository;
use Quiz\Repositories\UserDataBaseRepository;
use Quiz\Repositories\UserScoreDataBaseRepository;

class QuizServiceTwo
{
    /** @var QuizDataBaseRepository */
    private $quizRepo;
    /** @var UserDataBaseRepository */
    private $userRepo;
    /** @var UserAnswerDataBaseRepository */
    private $userAnswersRepo;
    /**
     * @var AnswerDataBaseRepository
     */
    private $answersRepo;
    /**
     * @var QuestionDatabaseRepository
     */
    private $questionRepo;

    private $scoreRepo;

    public function __construct(
        QuizDataBaseRepository $quizRepo,
        UserDataBaseRepository $userRepo,
        UserAnswerDataBaseRepository $userAnswersRepo,
        AnswerDataBaseRepository $answersRepo,
        QuestionDatabaseRepository $questionRepo,
        UserScoreDataBaseRepository $scoreRepo
    ) {
        $this->quizRepo = $quizRepo;
        $this->userRepo = $userRepo;
        $this->userAnswersRepo = $userAnswersRepo;
        $this->answersRepo = $answersRepo;
        $this->questionRepo = $questionRepo;
        $this->scoreRepo = $scoreRepo;
    }

    public function getAllQuezzes()
    {
        return $this->quizRepo->all();
    }

    public function getQuestion(int $quizId)
    {
        $condition["quiz_id"] = $quizId;
        $select = [];
        $questions = $this->questionRepo->all($condition, $select);
        $preparedQuestions = [];

        foreach ($questions as $question) {
            $tempArray['id'] = $question->id;
            $tempArray['question'] = $question->question;
            $tempArray['answers'] = $this->getAnswers($question->id);
            $preparedQuestions[] = $tempArray;
        }

        return $preparedQuestions;
    }

    public function getAnswers($questionId)
    {
        $condition["question_id"] = $questionId;
        $select[] = "id";
        $select[] = "answer";
        $answers = $this->answersRepo->all($condition, $select);
        $preparedAnswers = [];
        foreach ($answers as $answer) {
            $tempArray['id'] = $answer->id;
            $tempArray['answer'] = $answer->answer;
            $preparedAnswers[] = $tempArray;
        }
        return $preparedAnswers;
    }

    /**
     * @param $name
     * @return BaseModel
     */
    public function saveUser($name)
    {
        /** @var BaseModel $user */
        $user = $this->userRepo->create();
        $user->name = $name;
        $atribute = $this->userRepo->save($user);
        $user->name = $atribute["name"];
        $user->id = $atribute["id"];

        return $atribute["id"];
    }

    public function getQuestionIdFromAnswer($answerId)
    {
        $condition["id"] = $answerId;
        $result = $this->answersRepo->one($condition);
        return $questionId = $result->questionId;
    }

    public function getQuizIdFromQuestion($questionId)
    {
        $condition["id"] = $questionId;
        $result = $this->questionRepo->one($condition);
        return $quizId = $result->quizId;

    }

    public function saveUserAnswer($answerId, $userId)
    {

        $questionId = $this->getQuestionIdFromAnswer($answerId);
        $quizId = $this->getQuizIdFromQuestion($questionId);
        $userAnswerModel = new UserAnswerModel();
        $userAnswerModel->questionId = $questionId;
        $userAnswerModel->quizId = $quizId;;
        $userAnswerModel->answerId = $answerId;
        $userAnswerModel->userId = $userId;
        $this->userAnswersRepo->save($userAnswerModel);

    }

    public function getUserAnswers($userId)
    {
        $condition["user_id"] = $userId;
        return $this->userAnswersRepo->all($condition);

    }


    public function isUserAnswerCorrect($userAnswer)
    {
        $condition['id'] = $userAnswer->answerId;

        $answer = $this->answersRepo->one($condition);

        return $answer->isCorrect;
    }


    public function getCorrectAnswers($userId)
    {
        $answers = $this->getUserAnswers($userId);
        $correctAnswers = 0;
        $totalAnswers = 0;

        foreach ($answers as $answer) {
            if ($this->isUserAnswerCorrect($answer)) {
                $correctAnswers++;
            };

            $totalAnswers++;
        }

        $result['totalAnswers'] = $totalAnswers;
        $result['correctAnswers'] = $correctAnswers;

        return $result;

    }

    public function postScore($userId, $quizId, $score)
    {
        $scoreModel = new ScoreModel();
        $scoreModel->userId = $userId;
        $scoreModel->quizId = $quizId;
        $scoreModel->score = $score;
        $this->scoreRepo->save($scoreModel);

    }


}