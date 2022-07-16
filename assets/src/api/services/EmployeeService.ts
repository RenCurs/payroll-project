import Employee from '@/types/Employee'
import { AxiosApiClient } from '../client/AxiosApiClient'

const apiClient = new AxiosApiClient()

export default class EmployeeService {
    protected apiClient = apiClient

    public async getEmployeeById(id: number): Promise<Employee> {
        const response = await this.apiClient.get<Employee>(
            // TODO донастроить
            Routing.generate(''),
            { params: { id } }
        )

        return response.data
    }
}
