<template>

    <div class="container__results" v-if="result">

        <div class="container__results__title">Paldies {{name}}!
            <br>
            Tests ir izpildīts!
            Tu pareizi atbildēji uz: {{result}} jautājumiem!
            <br>
            <button class="container__results__button" @click="restart">Start again</button>
        </div>

        <br>


    </div>

</template>


<script>
    import {mapActions} from 'vuex';

    export default {

        name: 'Results',
        computed: {
            result: {
                get() {
                    return this.$store.state.result;
                }
            },
            name: {
                get() {
                    return this.$store.state.name;
                },

                set(newName) {
                    this.setName(newName);
                }
            },


        },

        methods: mapActions(['restart']),
    }

</script>