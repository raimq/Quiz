<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/14/2018
 * Time: 11:37 AM
 */

namespace Quiz\Repositories;

use Quiz\Models\UserAnswerModel;

class UserAnswerRepository
{
    /** @var UserAnswerModel[] */
    private $answers = [];


    public function saveAnswer(UserAnswerModel $userAnswer)
    {
        $this->answers[] = $userAnswer;
    }

    /**
     * @param int $quizId
     * @param int $userId
     * @return UserAnswerModel[]
     */
    public function getAnswers(int $userId, int $quizId): array
    {
        $result = [];
        foreach ($this->answers as $item) {
            if ($item->userId == $userId && $item->quizId == $quizId) {
                $result[] = $item;
            }
        }
        return $result;
    }
}