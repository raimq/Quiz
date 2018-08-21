<?php

namespace Quiz\Services;

use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;
use Quiz\Models\UserAnswerModel;
use Quiz\Models\UserModel;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserAnswerRepository;
use Quiz\Repositories\UserRepository;

class QuizServiceTwo
{
    /** @var QuizRepository */
    private $quizes;
    /** @var UserRepository */
    private $users;
    /** @var UserAnswerRepository */
    private $userAnswers;

    public function __construct(
        QuizRepository $quizzes,
        UserRepository $users,
        UserAnswerRepository $userAnswers
    ) {
        $this->quizes = $quizzes;
        $this->users = $users;
        $this->userAnswers = $userAnswers;
    }

    /**
     * Get list of available quizes
     *
     * @return QuizModel[]
     */
    public function getQuizes(): array
    {
        return $this->quizes->getList();
    }

    /**
     * Register a new user
     *
     * @param string $name
     * @return UserModel
     */
    public function registerUser(string $name): UserModel
    {
        $user = new UserModel;
        $user->name = $name;

        return $this->users->saveOrCreate($user);
    }


    /**
     * Get list of questions for a specific quiz
     *
     * @param $quizId
     * @return QuestionModel[]
     */
    public function getQuestions(int $quizId): array
    {
        return $this->quizes->getQuestions($quizId);
    }

    /**
     * Get list of available answers for this question
     *
     * @param int $questionId
     * @return AnswerModel[]
     */
    public function getAnswers(int $questionId): array
    {
        return $this->quizes->getAnswers($questionId);
    }

    /**
     * Submit current users answer
     *
     * @param int $userId
     * @param int $questionId
     * @param int $answerId
     * @param int $quizId
     */
    public function submitAnswer(int $userId, int $questionId, int $answerId, int $quizId)
    {
        $answer = new UserAnswerModel;
        $answer->userId = $userId;
        $answer->questionId = $questionId;
        $answer->answerId = $answerId;
        $answer->quizId = $quizId;

        $this->userAnswers->saveAnswer($answer);
    }

    /**
     * Check if user has answered all questions for this quiz (correct or incorrect)
     *
     * @param int $userId
     * @param int $quizId
     * @return bool
     */
    public function isQuizCompleted(int $userId, int $quizId): bool
    {
        $questionAmount = sizeof($this->quizes->getQuestions($quizId));
        $answersAmount = sizeof($this->userAnswers->getAnswers($userId, $quizId));

        return ($questionAmount == $answersAmount);
    }

    /**
     * Get score in the quiz in percentage round(right answers / answer count * 100)
     *
     * @param int $userId
     * @param int $quizId
     * @return int 0-100
     */

    public function getScore(int $userId, int $quizId): int
    {
        $answerCount = 0;
        $rightAnswers = 0;

        foreach ($this->userAnswers->getAnswers($userId, $quizId) as $answer) {
            $answerCount++;

            foreach ($this->quizes->getAnswers($answer->questionId) as $ans) {
                if ($ans->isCorrect) {
                    $rightAnswers++;
                }
            }
        }
        if ($rightAnswers == 0) {
            return 0;
        }

        return round(($rightAnswers / $answerCount) * 100);
    }

    /**
     * Check if user exists in the system (is valid)
     *
     * @param int $userId
     * @return bool
     */
    public function isExistingUser($userId): bool
    {
        if ($this->users->getById($userId)->id != null) {
            return true;
        }
        return false;
    }

    public function isExistingQuiz($quizId)
    {
        $quizzes = $this->getQuizes();
        foreach ($quizzes as $quiz) {
            if ($quiz->id == $quizId) {
                return true;
            }
        }
        return false;
    }

    public function isExistingQuestion($quizId, $questionId)
    {
        $questions = $this->quizes->getQuestions($quizId);

        foreach ($questions as $question) {
            if ($question->id == $questionId) {
                return true;
            }
        }
        return false;
    }

    public function isExistingAnswer($questionId, $answerId)
    {
        $answers = $this->quizes->getAnswers($questionId);

        foreach ($answers as $answer) {
            if ($answer->id == $answerId) {
                return true;
            }
        }
        return false;
    }

    public function isUserAnswersValid($userId, $quizId)
    {
        $userAnswers = $this->userAnswers->getAnswers($userId, $quizId);
        foreach ($userAnswers as $userAnswer) {
            $answerFound = false;
            foreach ($this->quizes->getAnswers($userAnswer->questionId) as $answer) {
                if ($answer->id == $userAnswer->answerId) {
                    $answerFound = true;
                }
            }
            if (!$answerFound) {
                return false;
            }
        }
        return true;
    }


    public function isDataValid($userId, $quizId, $questionId, $answerId)
    {
        if (!$this->isExistingQuiz($quizId) ||
            !$this->isUserAnswersValid($userId, $quizId) ||
            !$this->isExistingAnswer($questionId, $answerId) ||
            !$this->isExistingQuestion($quizId, $questionId) ||
            !$this->isExistingUser($userId)) {

            return false;
        }
        return true;
    }


}