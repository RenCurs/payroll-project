import { ActionContext, ActionTree } from 'vuex'
import { State } from '@/store/index'
import EmployeeService from '@/api/services/EmployeeService'
import Employee from '@/types/Employee'

export enum Actions {
    getEmployees = 'getEmployees',
    getEmployeeById = 'getEmployeeById'
}

const employeeService = new EmployeeService()

// TODO generic ActionTree ???
export const actions: ActionTree<State, State> = {
    async [Actions.getEmployeeById] (context: ActionContext<State, State>, id: number): Promise<Employee> {
        return await employeeService.getEmployeeById(id)
    },

    async [Actions.getEmployees] (): Promise<Array<Employee>> {
        return await employeeService.getEmployees()
    }
}
