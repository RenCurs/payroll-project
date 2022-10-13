import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import employeeRoutes from '@/components/accountant/routing'
import { loginRoute, registerRoute } from '@/components/authentication/routing'

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [];

const notFoundRoute: RouteConfig = {
    path: '*',
    component: () => import('@/components/NotFound.vue')
}

const router = new VueRouter({
    mode: 'history',
    routes: routes.concat(employeeRoutes, loginRoute, registerRoute, notFoundRoute)
});

export default router;
