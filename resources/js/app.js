require('./bootstrap');


window.Vue = require('vue').default;

import vuetify from '../plugins/vuetify';
import Vue from "vue";

import RegistrationComponent from "./components/RegistrationComponent.vue";

const app = new Vue({
    el: '#app',
    vuetify,
    components:{
        RegistrationComponent,
    }
});




