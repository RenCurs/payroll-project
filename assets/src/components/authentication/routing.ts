import { RouteConfig } from 'vue-router'

const loginRoute: RouteConfig = {
    path: '/',
    name: 'login',
    component: () => import('@/components/authentication/Login.vue')
}

const registerRoute: RouteConfig = {
    path: '/register',
    name: 'register',
    component: () => import('@/components/authentication/Register.vue')
}

export { loginRoute, registerRoute }
