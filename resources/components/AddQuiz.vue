<template>
    <div>

        <!--TODO;IMPLEMET BETTER ADD CLASSES, FIX ANSWER INPUT FIELDS SO ONLY ONE CHANGES, FIX STYLE -->
        <div class="container__admin">
            ADMIN PANEL
            <br>
            <input placeholder="Ievadies Testa Nosaukumu" type="text" v-model="quizName"/>


            <div class="container__admin__question">
                <input placeholder="Jautajums:" type="text" v-model="questionName"/>
                <button @click="addQuestion">AddQuestion</button>
            </div>

            <div v-for="question in questions">
                <div class="container__admin__question_title">Jautājums:{{question.name}}</div>
                <br>

                <div v-for="answer in answers">
                    <!--answersSsss-->
                    <!--QUEST ID: {{question.id}} ANWER ID : {{answer.id}}-->
                    <div v-if="question.id === answer.questionId">
                        {{answer.name}} | {{ answer.isCorrect}}
                    </div>
                </div>

                <input placeholder="Answer:" type="text" v-model="answerName"/>

                IsCorrect:<input v-model="isCorrect" name="IsCorrect" type="checkbox">

                <button @click="addAnswer(question.id)">AddAnswer</button>
            </div>


            <div>
                <button class="container__admin__button" @click="addQuiz">Save Quiz!</button>
            </div>


        </div>

    </div>


</template>

<script>

    import {mapActions} from 'vuex';

    export default {

        name: "AddQuiz",

        data: function () {
            return {

                quizName: null,

                questionName: null,

                amountOfQuestions: 0,

                questions: [],

                answers: [],

                isCorrect: false,

                answerName: null,

                Quiz: [],

            }
        },

        computed: {},

        methods: Object.assign({}, mapActions([
                'saveQuiz'
            ]),
            {
                setQuizName() {
                    this.Quiz.name = this.quizName;
                },

                addQuestion() {

                    this.questions.push({
                        name: this.questionName,
                        id: this.amountOfQuestions
                    });

                    this.amountOfQuestions++;

                },

                addAnswer(value) {

                    this.answers.push({
                        isCorrect: this.isCorrect,
                        questionId: value,
                        name: this.answerName,
                    });

                },

                addQuiz() {
                    console.log(this.answers);

                    this.Quiz.push(this.answers, this.questions, this.quizName);
                    console.log(this.Quiz);

                    this.saveQuiz(this.Quiz);

                    this.reset();
                },

                reset() {

                    this.quizName = null;
                    this.questionName = '';
                    this.answers = [];
                    this.questions = 0;
                    this.Quiz = 0;


                }
            }
        )


    }


</script>
