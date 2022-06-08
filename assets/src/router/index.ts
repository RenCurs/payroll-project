import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import mainRouting from '@/components/accountant/main/routing'

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [];

const router = new VueRouter({
    mode: 'history',
    routes: routes.concat(mainRouting)
});

export default router;
