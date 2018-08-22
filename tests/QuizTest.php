<?php
//
//namespace Quiz\Tests;
//
//use PHPUnit\Framework\TestCase;
//use Quiz\Models\AnswerModel;
//use Quiz\Models\QuestionModel;
//use Quiz\Models\QuizModel;
//use Quiz\Models\UserAnswerModel;
//use Quiz\Models\UserModel;
//use Quiz\Repositories\QuizRepository;
//use Quiz\Repositories\UserAnswerRepository;
//use Quiz\Repositories\UserRepository;
//use Quiz\Services\QuizServiceTwo;
//
//class QuizTest extends TestCase
//{
//    /** @var QuizRepository */
//    private $quizRepository;
//
//    private $answerRepository;
//
//    public function setUp()
//    {
//        parent::setUp();
//
//
//        $this->quizRepository = new QuizRepository;
//        $this->answerRepository = new UserAnswerRepository;
//
//
//        $data = [
//            'Country capitals' => [
//                'Latvia' => [
//                    'Riga' => true,
//                    'Ventspils' => false,
//                    'Jurmala' => false,
//                    'Daugavpils' => false,
//                ],
//                'Lithuania' => [
//                    'Kaunas' => false,
//                    'Siaulia' => false,
//                    'Vilnius' => true,
//                    'Mazeikiai' => false,
//                ],
//                'Estonia' => [
//                    'Talling' => true,
//                    'Paarnu' => false,
//                    'Tartu' => false,
//                    'Valga' => false,
//                ],
//            ],
//        ];
//
//
//        $quizIds = 0;
//        $questionIds = 0;
//        $answerIds = 0;
//
//        foreach ($data as $quizTitle => $questions) {
//            $quiz = new QuizModel;
//            $quiz->id = ++$quizIds;
//            $quiz->name = $quizTitle;
//
//            $this->quizRepository->addQuiz($quiz);
//
//            foreach ($questions as $questionText => $answers) {
//                $question = new QuestionModel;
//                $question->quizId = $quiz->id;
//                $question->id = ++$questionIds;
//                $question->question = $questionText;
//
//                $this->quizRepository->addQuestion($question);
//
//                foreach ($answers as $answerText => $isCorrect) {
//                    $a = new AnswerModel;
//                    $a->id = ++$answerIds;
//                    $a->answer = $answerText;
//                    $a->isCorrect = $isCorrect;
//                    $a->questionId = $question->id;
//
//                    $this->quizRepository->addAnswer($a);
//                }
//            }
//        }
//
//    }
//
//    public function testQuizRetrievalById()
//    {
//        $quiz = $this->quizRepository->getById(1);
//        self::assertEquals(1, $quiz->id);
//    }
//
//    public function testSubmittedAnswerIsFound()
//    {
//        $repo = new UserAnswerRepository;
//        $answer = new UserAnswerModel;
//
//        $answer->quizId = 222;
//        $answer->questionId = 1;
//        $answer->userId = 111;
//
//        $repo->saveAnswer($answer);
//
//        $answer->quizId = 222;
//        $answer->questionId = 2;
//        $answer->userId = 111;
//
//        $repo->saveAnswer($answer);
//
//        $answerFound = $repo->getAnswers(111, 222);
//        $answersTemp = reset($answerFound);
//
//        self::assertEquals($answersTemp, $answer);
//    }
//
//
//    public function testGetAllQuestionsByQuizId()
//    {
//        $repo = new QuizRepository;
//        $questions = new QuestionModel;
//        $questions->quizId = 3;
//        $questions->id = 3;
//        $questions->question = 'Hello World';
//
//        $repo->addQuestion($questions);
//        $questionsFound = $repo->getQuestions(3);
//        $questionsFound = array_shift($questionsFound);
//        self::assertEquals($questions, $questionsFound);
//
//    }
//
//    public function testIfCanGetAllAnswers()
//    {
//        $repo = new QuizRepository;
//        $answer = new AnswerModel;
//
//        $answer->id = 1;
//        $answer->answer = 'Hello';
//        $answer->questionId = '2';
//        $answer->isCorrect = false;
//
//        $repo->addAnswer($answer);
//
//        $answerGot = $repo->getAnswers(2);
//        $answerGot = array_shift($answerGot);
//
//        self::assertEquals($answer, $answerGot);
//
//    }
//
//    public function testIfUserIsCreated()
//    {
//        $repo = new UserRepository;
//        $user = new UserModel();
//
//        $user->id = 3;
//        $user->name = 'Karlis';
//        $repo->saveOrCreate($user);
//
//        $userGot = $repo->getById(3);
//        self::assertEquals($user, $userGot);
//
//
//    }
//
//    function testStuff()
//    {
//        $userAnswerRepo = new UserAnswerRepository;
//        $userRepo = new UserRepository;
//        $quizRepo = new QuizRepository;
//
//        $service = new QuizServiceTwo($quizRepo, $userRepo, $userAnswerRepo);
//
//        // Add a quiz model to repositoru
//        $quiz = new QuizModel;
//        $quiz->name = 'Hello World';
//        $quiz->id = 1;
//
//        $quizRepo->addQuiz($quiz);
//
//        // Check if service returns the quiz
//        $quizzes = $service->getQuizes();
//
//        self::assertCount(1, $quizzes);
//    }
//
//
//    function testGetListOfQuizes()
//    {
//        $quiz = new QuizModel;
//        $repo = new QuizRepository;
//
//        $quiz->id = 1;
//        $quiz->name = 'Hello';
//
//        $repo->addQuiz($quiz);
//        $quiz2 = new QuizModel;
//        $quiz2->id = 2;
//        $quiz2->name = 'Hello2';
//        $repo->addQuiz($quiz2);
//
//        $quizes = $repo->getList();
//
//        self::assertCount(2, $quizes);
//    }
//
//
//}