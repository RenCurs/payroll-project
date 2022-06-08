import { RouteConfig } from 'vue-router'

const route: RouteConfig = {
    path: '/main',
    name: 'main',
    component: () => import('@/components/accountant/main/Main.vue')
}

export default route
