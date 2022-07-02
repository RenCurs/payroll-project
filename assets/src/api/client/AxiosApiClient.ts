import axios, { AxiosInstance } from 'axios'
import { Response, ConfigRequest, HttpClientInterface } from '@/api/client/ClientInterface'
import routes from '../../../fos_js_routes.json'
import { Router } from 'symfony-ts-router'

const axiosInstance = axios.create({
    headers: {
        'Content-type': 'application/json'
    }
})

export class AxiosApiClient implements HttpClientInterface {
    private httpClient: AxiosInstance = axiosInstance

    public async get<Type>(url:string, config?: ConfigRequest<Type>): Promise<Response<Type>> {
        const response = await this.httpClient.get<Type>(url, config)
        return { code: response.status, data: response.data }
    }

    public async post<Type, Res>(url: string, data: Type, config?: ConfigRequest<Type>): Promise<Response<Res>> {
        const response = await this.httpClient.post<Type>(url, data, config)

        return { code: response.status, data: response.data as unknown as Res }
    }

    public async patch<Type, Res>(url: string, data: Type, config?: ConfigRequest<Type>): Promise<Response<Res>> {
        const response = await this.httpClient.patch<Type>(url, data, config)

        return { code: response.status, data: response.data as unknown as Res }
    }

    public async delete<Type>(url:string, config?: ConfigRequest<Type>): Promise<Response<Type>> {
        const response = await this.httpClient.delete<Type>(url, config)

        return { code: response.status, data: response.data }
    }
}
