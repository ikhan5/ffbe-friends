import Vue from "vue";
import VueRouter from "vue-router";
import VueEx from "vuex";

import App from "./App.vue";
import Header from "./components/Header";

import { routes } from "./routes";

Vue.use(VueRouter);
Vue.use(VueEx);

export const store = new VueEx.Store({
    state: {
        user: null
    },
    mutations: {
        setAuthUser(state, user) {
            state.user = user;
        }
    },
    getters: {
        isLoggedIn(state) {
            return state.user !== null;
        }
    }
});

const router = new VueRouter({
    mode: "history",
    routes
});

Vue.filter('friendCode', value => {
    if(!value) return ''
    value.toString();
    return value.replace(/(.)(?=(.{3})+$)/g,"$1,");
  })

const app = new Vue({
    el: "#app",
    components: {
        App,
        store,
        AppHeader: Header
    },
    router
});
