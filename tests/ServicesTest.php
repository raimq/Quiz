<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/15/2018
 * Time: 9:40 AM
 */

namespace Quiz\Tests;

use PHPUnit\Framework\TestCase;
use Quiz\Models\AnswerModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;
use Quiz\Models\UserAnswerModel;
use Quiz\Models\UserModel;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserAnswerRepository;
use Quiz\Repositories\UserRepository;
use Quiz\Services\QuizServiceTwo;

class ServicesTest extends TestCase
{
    /** @var UserAnswerRepository */
    private $userAnswerRepo;

    /** @var UserRepository */
    private $userRepo;

    /** @var QuizRepository */
    private $quizRepo;

    /** @var QuizServiceTwo */
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->quizRepo = new QuizRepository();
        $this->userRepo = new UserRepository();
        $this->userAnswerRepo = new UserAnswerRepository;
        $this->service = new QuizServiceTwo($this->quizRepo, $this->userRepo, $this->userAnswerRepo);
    }

    function testGetListOfQuizes()
    {


        $quiz = new QuizModel;
        $quiz->id = 1;
        $quiz->name = 'Hello';
        $this->quizRepo->addQuiz($quiz);

        self::assertCount(1, $this->service->getQuizes());
    }


    function testRegisterUser()
    {


        $this->service->registerUser('Karlis');
        $this->service->registerUser('Peteris');

        self::assertCount(2, $this->userRepo->getAll());

    }

    function testIfUserExistWorks()
    {
        $user = new UserModel;
        $user->id = 1;
        $user->name = 'Peteris';

        $this->userRepo->saveOrCreate($user);

        self::assertTrue($this->service->isExistingUser(1));
        self::assertFalse($this->service->isExistingUser(2));

    }

    function testIfServiceGetQuestionsWork()
    {


        $question = new QuestionModel;
        $question->quizId = 3;
        $question->question = 'Hello';
        $question->id = 1;
        $this->quizRepo->addQuestion($question);
        $question2 = new QuestionModel;
        $question2->id = 2;
        $question2->quizId = 3;
        $question2->question = 'Not Hello';
        $this->quizRepo->addQuestion($question2);

        self::assertCount(2, $this->service->getQuestions(3));

    }

    function testIfServiceGetAnswersWork()
    {


        $answer = new AnswerModel;

        $answer->questionId = 1;
        $answer->answer = 'asd';
        $answer->id = 2;
        $answer->isCorrect = true;
        $this->quizRepo->addAnswer($answer);

        self::assertCount(1, $this->quizRepo->getAnswers(1));
        self::assertCount(1, $this->service->getAnswers(1));

    }


    function testSubmitAnswerService()
    {
        $this->service->submitAnswer(3, 1, 1, 1);

        self::assertCount(1, $this->userAnswerRepo->getAnswers(3, 1));

    }

    function testQuizCompleted()
    {
        $question = new QuestionModel;
        $question->id = 2;
        $question->question = 'hello';
        $question->quizId = 3;
        $this->quizRepo->addQuestion($question);


        $userAnswers = new UserAnswerModel;
        $userAnswers->id = 2;
        $userAnswers->quizId = 3;
        $userAnswers->userId = 3;
        $userAnswers->questionId = 1;
        $userAnswers->answerId = 1;

        $this->userAnswerRepo->saveAnswer($userAnswers);


        self::assertTrue($this->service->isQuizCompleted(3, 3));

    }


    function testScore()
    {

        $userAnswers = new UserAnswerModel;
        $userAnswers->id = 2;
        $userAnswers->quizId = 3;
        $userAnswers->userId = 3;
        $userAnswers->questionId = 1;
        $userAnswers->answerId = 1;
        $this->userAnswerRepo->saveAnswer($userAnswers);

        $userAnswers2 = new UserAnswerModel;
        $userAnswers2->id = 2;
        $userAnswers2->quizId = 3;
        $userAnswers2->userId = 3;
        $userAnswers2->questionId = 2;
        $userAnswers2->answerId = 2;
        $this->userAnswerRepo->saveAnswer($userAnswers2);

        $answers = new AnswerModel;
        $answers->isCorrect = true;
        $answers->answer = 'Hello';
        $answers->questionId = 1;
        $answers->id = 1;
        $this->quizRepo->addAnswer($answers);

        $answers2 = new AnswerModel;
        $answers2->isCorrect = false;
        $answers2->answer = 'Hello';
        $answers2->questionId = 2;
        $answers2->id = 1;
        $this->quizRepo->addAnswer($answers2);


        self::assertEquals(50, $this->service->getScore(3, 3));


    }


    function testIsExistingQuiz()
    {
        $quiz = new QuizModel();
        $quiz->id = 1;
        $quiz->name = "Hello";
        $this->quizRepo->addQuiz($quiz);

        self::assertTrue($this->service->isExistingQuiz(1));
        self::assertFalse($this->service->isExistingQuiz(2));

    }


    function testIsExistingQuestion()
    {
        $question = new QuestionModel;

        $question->id = 1;
        $question->question = 'asd';
        $question->quizId = 2;

        $this->quizRepo->addQuestion($question);

        self::assertTrue($this->service->isExistingQuestion(2, 1));
        self::assertFalse($this->service->isExistingQuestion(3, 2));

    }

    function testIsExistingAnswer()
    {
        $answer = new AnswerModel();
        $answer->answer = 'asd';
        $answer->id = 1;
        $answer->questionId = 3;
        $answer->isCorrect = 'false';

        $this->quizRepo->addAnswer($answer);

        self::assertTrue($this->service->isExistingAnswer(3, 1));
        self::assertFalse($this->service->isExistingAnswer(3, 2));

    }

    function testIsUserAnswersValid()
    {
        $answer = new AnswerModel;
        $answer->questionId = 1;
        $answer->answer = 'Hello';
        $answer->isCorrect = true;
        $answer->id = 1;

        $this->quizRepo->addAnswer($answer);

        $answer1 = new AnswerModel;
        $answer1->questionId = 2;
        $answer1->answer = 'Hello';
        $answer1->isCorrect = true;
        $answer1->id = 3;

        $this->quizRepo->addAnswer($answer1);

        $userAnswer = new UserAnswerModel;
        $userAnswer->id = 10;
        $userAnswer->questionId = 1;
        $userAnswer->answerId = 1;
        $userAnswer->quizId = 1;
        $userAnswer->userId = 1;

        $this->userAnswerRepo->saveAnswer($userAnswer);

        $userAnswer1 = new UserAnswerModel;
        $userAnswer1->id = 10;
        $userAnswer1->questionId = 2;
        $userAnswer1->answerId = 3;
        $userAnswer1->quizId = 1;
        $userAnswer1->userId = 1;

        $this->userAnswerRepo->saveAnswer($userAnswer1);


        self::assertTrue($this->service->isUserAnswersValid(1, 1));

    }

    function testIsDataValid()
    {
        $user = new UserModel();
        $user->id = 1;
        $user->name = 'Karlis';
        $this->userRepo->saveOrCreate($user);

        $quiz = new QuizModel();
        $quiz->name = 'Valstis';
        $quiz->id = 1;
        $this->quizRepo->addQuiz($quiz);


        $question = new QuestionModel();
        $question->id = 1;
        $question->question = 'USA';
        $question->quizId = 1;
        $this->quizRepo->addQuestion($question);

        $annswer = new AnswerModel();
        $annswer->id = 1;
        $annswer->questionId = 1;
        $annswer->answer = 'WAS';
        $annswer->isCorrect = true;
        $this->quizRepo->addAnswer($annswer);

        $userAnswer = new UserAnswerModel();
        $userAnswer->questionId = 1;
        $userAnswer->id = 1;
        $userAnswer->quizId = 1;
        $userAnswer->userId = 1;
        $userAnswer->answerId = 1;
        $this->userAnswerRepo->saveAnswer($userAnswer);

        self::assertTrue($this->service->isDataValid(1, 1, 1, 1));
        self::assertFalse($this->service->isDataValid(2, 2, 2, 2));
    }


}