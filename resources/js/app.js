import Vue from 'vue'
import VueRouter from "vue-router";

import App from './App.vue'
import Header from './components/Header'

import { routes } from "./routes";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
  });

const app = new Vue({
    el: '#app',
    components:{
        App,
        AppHeader: Header
    },
    router
});
