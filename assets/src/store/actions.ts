import { ActionContext, ActionTree } from 'vuex'
import { State } from '@/store/index'
import EmployeeService from '@/api/services/EmployeeService'
import Employee from '@/types/Employee'
import Client from '@/types/Client'
import AuthService from '@/api/services/AuthService'

export enum Actions {
    getEmployees = 'getEmployees',
    getEmployeeById = 'getEmployeeById',
    updateEmployee = 'updateEmployee',
    deleteEmployee = 'deleteEmployee',
    createEmployee = 'createEmployee',
    login = 'login'
}

const employeeService = new EmployeeService()
const authService = new AuthService()

export const actions: ActionTree<State, State> = {
    async [Actions.getEmployeeById] (context: ActionContext<State, State>, id: number): Promise<Employee> {
        return await employeeService.getEmployeeById(id)
    },
    async [Actions.getEmployees] (): Promise<Array<Employee>> {
        return await employeeService.getEmployees()
    },
    async [Actions.updateEmployee] (context: ActionContext<State, State>, employee: Employee): Promise<Employee> {
        return await employeeService.updateEmployee(employee)
    },
    async [Actions.deleteEmployee] (context: ActionContext<State, State>, employeeId: number): Promise<void> {
        return await employeeService.deleteEmployee(employeeId)
    },
    async [Actions.createEmployee] (context: ActionContext<State, State>, employee: Employee): Promise<Employee> {
        return await employeeService.createEmployee(employee)
    },
    async [Actions.login] (context: ActionContext<State, State>, client: Client): Promise<void> {
        return await authService.login(client)
    }
}
