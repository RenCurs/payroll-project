import { RouteConfig } from 'vue-router'

const employeeRoutes: Array<RouteConfig> = [
    {
        path: '/employees/',
        name: 'employee_list',
        component: () => import('@/components/accountant/main/Main.vue')
    },
    {
        props: true,
        path: '/employees/edit/:employeeId',
        name: 'edit_employee',
        component: () => import('@/components/accountant/edit/EditEmployee.vue')
    },
    {
        path: '/employees/create',
        name: 'create_employee',
        component: () => import('@/components/accountant/create/CreateEmployee.vue')
    }
]

export default employeeRoutes
