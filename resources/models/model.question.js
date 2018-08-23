import Answer from "./model.answer";

export default class Question {
    constructor() {
        /**
         *
         * @type {?number}
         */
        this.id = null;
        /**
         *
         * @type {string}
         */
        this.question = '';
        /**
         *
         * @type {Array<Answer>}
         */
        this.answers = [];

        this.percentCompleted = null;
    }

    /**
     *
     * @param {{}}rawData
     * @return {Question}
     */
    static fromArray(rawData) {
        let question = new Question();
        question.id = rawData.id;
        question.question = rawData.question;
        question.answers = rawData.answers.map(Answer.fromArray);
        question.percentCompleted = rawData.percentCompleted;
        return question;
    }
}