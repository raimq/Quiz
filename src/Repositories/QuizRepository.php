<?php

namespace Quiz\Repositories;

use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;

class QuizRepository
{
    /** @var QuizModel[] */
    private $quizes = [];
    /** @var QuestionModel[] */
    private $questions = [];
    /** @var AnswerModel[] */
    private $answers = [];
    /** @var QuizModel[] */
    private $id = [];

    public function addQuiz(QuizModel $quiz)
    {
        $this->quizes[] = $quiz;
    }

    public function addQuestion(QuestionModel $question)
    {
        $this->questions[] = $question;
    }

    public function addAnswer(AnswerModel $answer)
    {
        $this->answers[] = $answer;
    }

    public function getById(int $quizId): QuizModel
    {
        foreach ($this->quizes as $v) {
            if ($v->id == $quizId) {
                return $v;
            }
        }
        return new QuizModel; // Returns empty model
    }

    /**
     * @param int $quizId
     * @return QuestionModel[]
     */

    public function getQuestions(int $quizId)
    {
        $questions = [];

        foreach ($this->questions as $question) {
            if ($question->quizId == $quizId) {
                $questions[] = $question;
            }
        }
        return $questions;
    }

    /**
     * @param int $questionId
     * @return AnswerModel[]
     */
    public function getAnswers(int $questionId): array
    {
        $answers = [];
        foreach ($this->answers as $answer) {
            if ($answer->questionId == $questionId) {
                $answers[] = $answer;
            }
        }
        return $answers;
    }

    /**
     * @return QuizModel[]
     */

    public function getList(): array
    {
        $quizzes = [];

        foreach ($this->quizes as $quize) {
            $quizzes[] = $quize;

        }
        return $quizzes;
    }


}