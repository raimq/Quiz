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
            this.quizApi.post('start', {name, quizId})
                .then(response => {
                    let question = Question.fromArray(response.data.result);

                    resolve(question)
                })
                .catch(() => alert('Oh noooo!'));
        })
    }

    answer(answerId) {
        return new Promise(resolve => {
            this.quizApi.post('answer', {answerId})
                .then(response => {
                    resolve(
                        ( typeof response.data.result === 'string') ?
                            response.data.result :
                            Question.fromArray(response.data.result));
                })
                .catch(() => {
                    debugger;
                })
        })
    }
}

export default new QuizRepository();