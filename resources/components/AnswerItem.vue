<template>
    <a href="#" @click="onAnswerPicked" :class="isActive ? 'active' : ''">{{ answer.answer }}</a>
</template>

<script>
    import Answer from '../models/model.answer.js';

    export default {
        name: "AnswerItem",
        props: {
            answer: {
                type: Answer,
                required: true,
            },

            onAnswered: {
                type: Function,
                required: true,
            },
            isActive: Boolean,
        },

        methods: {
            onAnswerPicked() {
                console.log(this.answer.id);
                this.onAnswered(this.answer.id);
            }
        }
    }
</script>
