import Api from '../api.js';
import Quiz from "../models/model.quiz";
import Question from "../models/model.question";

class QuizRepository {

    constructor() {
        this.quizApi = new Api('AjaxSecond'); //controllers
    }

    /**
     * @return {Promise}
     */
    getAllQuizzes() {
        return new Promise(resolve => {

                this.quizApi.get('getAllQuizzes')  //function
                    .then(response => {
                        console.log(response);
                        let quizzes = response.data.result.map(Quiz.fromArray);

                        resolve(quizzes);
                    })
                //.catch(()=>alert('Something went wrong'));
            }
        )
    }

    start(name, quizId) {
        return new Promise(resolve => {
            console.log("quizID", quizId);
            this.quizApi.post('start', {name, quizId})
                .then(response => {
                    let question = Question.fromArray(response.data.result);
                    console.log(response);
                    resolve(question)
                })
                .catch(() => alert('Oh noooo!'));
        })
    }

    answer(answerId, quizId) {
        console.log("quizId:", quizId);
        return new Promise(resolve => {
            this.quizApi.post('answer', {answerId, quizId})
                .then(response => {
                    console.log(response);
                    resolve(
                        (typeof response.data.result === 'string') ?
                            response.data.result :
                            Question.fromArray(response.data.result));
                    console.log(response)
                })
                .catch(() => {
                    debugger;
                })
        })
    }

    saveQuiz(quiz) {
        console.log('Quiz:', quiz);
        return new Promise(resolve => {
            this.quizApi.post('newQuiz', {quiz})
                .then(response => {
                    console.log(response);
                })
        })
    }

    getIfPasswordCorrect(password) {
        return new Promise(resolve => {
            this.quizApi.post('passwordCheck', {password})
                .then(response => {
                    let answer = response.data.result;
                    resolve(answer);
                })
        })
    }


}

export default new QuizRepository();