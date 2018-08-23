<template>
    <div class="container">
        <div v-if="!activeQuestion && !result && !admin">
            <h2 class="container__title">Sveiks!</h2>

            <div class="container__input">
                <div>
                    <label class="container__input__labels">Ievadi vārdu :</label><br>
                    <input class="container__input__inputFields" placeholder="Ievadiet Vārdu..." type="text"
                           v-model="name"/>
                </div>

                <div>
                    <label class="container__input__labels">Izvēlies testu:</label><br>


                    <select class="container__input__inputFields" v-model="activeQuizId">
                        <option v-for="quiz in allQuizzes" :value="quiz.id">{{ quiz.name }}</option>
                    </select>
                </div>

                <div>
                    <button @click="onStart">Start</button>
                </div>

            </div>

        </div>

        <div v-else-if="activeQuestion">
            <h1 class="container__title">Hello, {{name}}!</h1>
            <QuestionItem/>
        </div>

        <div v-if="name ==='admin'">
            <input class="container__input__inputFields" placeholder="Ievadiet paroli:" type="password"
                   v-model="password"/>
            <button @click="onAddQuiz">Add Quiz</button>
        </div>

        <div v-if="admin">
            <AddQuiz/>
        </div>

        <Results/>


    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import Quiz from '../models/model.quiz';
    import QuestionItem from "./QuestionItem";
    import Results from './Results';
    import AddQuiz from './AddQuiz';


    export default {
        name: "Quiz",
        components: {QuestionItem, Results, AddQuiz},

        computed: {
            name: {
                get() {
                    return this.$store.state.name;
                },

                set(newName) {
                    this.setName(newName);
                }
            },


            activeQuizId: {
                get() {
                    return this.$store.state.activeQuizId;
                },
                set(newValue) {
                    this.setActiveQuizId(newValue);
                }
            },

            allQuizzes: {
                get() {
                    return this.$store.state.allQuizzes;
                }
            },

            activeQuestion: {
                get() {
                    return this.$store.state.activeQuestion;
                }

            },

            result: {
                get() {
                    return this.$store.state.result;
                }
            },

            admin: {
                get() {
                    return this.$store.state.admin;
                }
            },

            password: {
                set(password) {
                    this.setPassword(password);
                },
                get() {
                    return this.$store.state.password;
                }
            }

        },
        methods: Object.assign({}, mapActions([
            'setAllQuizzes',
            'setActiveQuizId',
            'setName',
            'start',
            'setAdmin',
            'setPassword',
        ]), {
            onStart() {
                if (!this.name) {
                    alert('Please enter name');
                    return;
                }

                if (!this.activeQuizId) {
                    alert('Please pick Quiz');
                    return;
                }

                this.start();
            },

            onAddQuiz() {
                this.name = '';
                console.log("onAddQuiz");
                this.setAdmin();
            },


        }),
        created() {
            this.setAllQuizzes();
        }

    }
</script>
