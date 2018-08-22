<template>

    <div class="container__questions">
        <h2 class="container__questions__question">{{question.question}}</h2>
        <ul class="container__questions__answers">
            <li class="container__questions__answers__item" v-for="answer in question.answers" >
                <AnswerItem class="container__questions__answers__item__listText" :answer="answer"
                            :on-answered="onAnswerPicked"/>

            </li>


        </ul>

        <div class="container__questions__button">
            <button class="container__questions__button_text" @click.stop="onAnswered">Next Question</button>
        </div>
    </div>

</template>

<script>
    import AnswerItem from "./AnswerItem";
    import {mapActions} from 'vuex';

    export default {
        name: "QuestionItem",
        components: {AnswerItem},
        data() {
            return {
                answerId: null,
            }
        },
        computed: {
            question: {
                get() {
                    return this.$store.state.activeQuestion;
                }
            }
        },

        methods: Object.assign({}, mapActions([
                'answer'
            ]),
            {
                onAnswerPicked(answerId) {
                    console.log(answerId);
                    this.answerId = answerId;
                },

                onAnswered() {
                    if (!this.answerId) {
                        alert('No answer picked');
                    }
                    console.log(this.answerId);
                    this.answer(this.answerId);
                    this.reset();
                },

                reset() {
                    this.answerId = null;
                }

            }
        )
    }
</script>