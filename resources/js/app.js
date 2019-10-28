import Vue from "vue";
import VueRouter from "vue-router";
import VueEx from "vuex";
import VueSelect from "vue-select";

import App from "./App.vue";
import Header from "./components/Header";
import Spinner from "./components/Spinner";

import { routes } from "./routes";

Vue.use(VueRouter);

Vue.component("app-v-select", VueSelect);
Vue.component("app-spinner", Spinner);


const router = new VueRouter({
    mode: "history",
    routes
});

Vue.filter("friendCode", value => {
    if (!value) return "";
    value.toString();
    return value.replace(/(.)(?=(.{3})+$)/g, "$1,");
});

export const eventBus = new Vue();

const app = new Vue({
    el: "#app",
    components: {
        App,
        AppHeader: Header
    },
    router
});
