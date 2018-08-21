<template>

    <div>
        <h1>{{question.question}}</h1>

        <ul>
            <li v-for="answer in question.answers">
                <AnswerItem :answer="answer" :on-answered="onAnswerPicked"/>
            </li>
        </ul>
        <button @click="onAnswered">Next Question</button>

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
                    this.answerId = answerId;
                },

                onAnswered() {
                    if (!this.answerId) {
                        alert('noAnswerPicked');
                        return;
                    }
                    this.answer(this.answerId);
                }

            }
        )
    }
</script>