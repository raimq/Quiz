import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);

export default class Api {

    constructor(controllerName) {
        this.controlerName = controllerName;
    }

    /**
     * @param {string} action
     * @param {{}}[params]
     * @return {AxiosPromise}
     */
    get(action, params) {
        console.log(this.buildUrl(action));

       return Vue.axios.get(this.buildUrl(action),params ? Api.parseParams(params) : {})
    }

    /**
     *
     * @param {string} action
     * @param {{}}params
     * @return {AxiosPromise}
     */
    post(action, params) {
        console.log('params');
        console.log(params);
        return Vue.axios.post(this.buildUrl(action), params ? params : {});
    }

    buildUrl(url){
        return'/' +this.controlerName + '/' +url;
    }

    static parseParams(object){
        let params = new URLSearchParams();
        for (let key in object){
            params.append(key,object[key]);
        }
    }

}