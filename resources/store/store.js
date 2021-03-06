import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './mutations.js';
import QuizRepository from '../repositories/repository.quiz.js';
import Question from "../models/model.question.js";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        name: '',
        activeQuizId: null,
        allQuizzes: [],
        allQuestions: [],
        activeQuestion: null,
        result: '',
        admin: false,
        password: '',
        questionAmount:null,
    },

    mutations: {
        [types.SET_ACTIVE_QUIZ](state, quizId) {
            state.activeQuizId = quizId;
        },

        [types.SET_ALL_QUIZZES](state, quizzes) {
            state.allQuizzes = quizzes;
        },

        [types.SET_NAME](state, name) {
            state.name = name;
        },

        [types.SET_QUESTION](state, question) {
            state.activeQuestion = question;
        },

        [types.SET_RESULTS](state, result) {
            state.result = result;
        },

        [types.SET_ADMIN](state, admin) {
            state.admin = admin;
        },

        [types.SET_PASSWORD](state, password) {
            state.password = password;
        },

        [types.SET_QUESTION_AMOUMT](state, amount){
            state.questionAmount = amount;
        }


    },

    actions: {

        setActiveQuizId(context, quizId) {
            context.commit(types.SET_ACTIVE_QUIZ, quizId);
        },

        setAllQuizzes(context) {
            QuizRepository.getAllQuizzes()
                .then(quizzes => {
                    context.commit(types.SET_ALL_QUIZZES, quizzes);
                });
        },

        setAdmin(context) {
            QuizRepository.getIfPasswordCorrect(this.state.password)
                .then(password => {
                    context.commit(types.SET_ADMIN, password)
                })


        },


        setName(context, name) {
            context.commit(types.SET_NAME, name);
        },

        start(context) {
            QuizRepository.start(this.state.name, this.state.activeQuizId)
                .then(question => {
                    context.commit(types.SET_QUESTION, question)
                });

        },

        setPassword(context, password) {
            context.commit(types.SET_PASSWORD, password);
        },


        answer(context, answerId) {
            QuizRepository.answer(answerId, this.state.activeQuizId)
                .then(questionOrResults => {
                    if (questionOrResults instanceof Question) {
                        context.commit(types.SET_QUESTION, questionOrResults);
                    } else {
                        context.commit(types.SET_QUESTION, null);
                        context.commit(types.SET_RESULTS, questionOrResults);
                    }
                });
        },

        saveQuiz(context, quiz){
            QuizRepository.saveQuiz(quiz);
        },

        restart(context) {
            context.commit(types.SET_ACTIVE_QUIZ, null);
            context.commit(types.SET_RESULTS, null);
        },

    }
});