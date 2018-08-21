import Vue from 'vue';
import Quiz from './components/Quiz.vue';
import store from './store/store.js';

new Vue({
    el: '#app',
    store,
    render: h => h(Quiz)
});
