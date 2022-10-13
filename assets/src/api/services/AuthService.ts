import BaseService from '@/api/services/BaseService'
import Client from '@/types/Client'

export default class AuthService extends BaseService {
    public async login(client: Client): Promise<void> {
        await this.apiClient.post<Client, unknown>(
            this.router.generate('app_login'),
            client
        )
    }
}
