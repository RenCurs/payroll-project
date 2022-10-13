import Employee from '@/types/Employee'
import BaseService from '@/api/services/BaseService'

export default class EmployeeService extends BaseService {
    public async getEmployeeById(id: number): Promise<Employee> {
        const response = await this.apiClient.get<Employee>(
            this.router.generate('api_get_employee', { id })
        )

        return response.data
    }

    public async getEmployees(): Promise<Array<Employee>> {
        const response = await this.apiClient.get<Array<Employee>>(
            this.router.generate('api_get_employee')
        )

        return response.data
    }

    public async updateEmployee(employee: Employee): Promise<Employee> {
        const response = await this.apiClient.patch<Employee, Employee>(
            this.router.generate('api_update_employee', { employeeId: employee.id }),
            employee
        )

        return response.data
    }

    public async deleteEmployee(employeeId: number): Promise<void> {
        await this.apiClient.delete<unknown>(
            this.router.generate('api_delete_employee', { employeeId })
        )
    }

    public async createEmployee(employee: Employee): Promise<Employee> {
        const response = await this.apiClient.post<Employee, Employee>(
            this.router.generate('api_create_employee'),
            employee
        )

        return response.data
    }
}
