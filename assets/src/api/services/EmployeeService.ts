import Employee from '@/types/Employee'
import { AxiosApiClient } from '../client/AxiosApiClient'
import routes from '../../../fos_js_routes.json'
import { Router, RoutingData } from 'symfony-ts-router'

const apiClient = new AxiosApiClient()
const router = new Router()
router.setRoutingData(routes as unknown as RoutingData)

export default class EmployeeService {
    protected apiClient = apiClient

    public async getEmployeeById(id: number): Promise<Employee> {
        const response = await this.apiClient.get<Employee>(
            router.generate('api_get_employee', { id })
        )

        return response.data
    }

    public async getEmployees(): Promise<Array<Employee>> {
        const response = await this.apiClient.get<Array<Employee>>(
            router.generate('api_get_employee')
        )

        return response.data
    }

    public async updateEmployee(employee: Employee): Promise<Employee> {
        const response = await this.apiClient.post<Employee, Employee>(
            router.generate('api_update_employee'),
            employee
        )

        return response.data
    }
}
