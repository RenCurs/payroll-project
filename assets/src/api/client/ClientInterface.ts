interface Response<T> {
    code: number,
    data: T
}

interface ConfigRequest<D> {
    url?: string;
    baseURL?: string;
    params?: unknown;
    paramsSerializer?: (params: unknown) => string;
    data?: D;
}

// TODO ???
interface HttpClientInterface {
    get<Type>(url: string, config?: ConfigRequest<Type>): Promise<Response<Type>>
    post<Type, Res>(url: string, data: Type, config?: ConfigRequest<Type>): Promise<Response<Res>>
    patch<Type, Res>(url: string, data: Type, config?: ConfigRequest<Type>): Promise<Response<Res>>
    delete<Type>(url: string, data: Type, config?: ConfigRequest<Type>): Promise<Response<Type>>
}

export { Response, ConfigRequest, HttpClientInterface }
