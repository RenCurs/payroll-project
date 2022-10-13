
import routes from '../../../fos_js_routes.json'
import { Router, RoutingData } from 'symfony-ts-router'
import { AxiosApiClient } from '@/api/client/AxiosApiClient'

const apiClient = new AxiosApiClient()
const router = new Router()
router.setRoutingData(routes as unknown as RoutingData)

export default class BaseService {
    protected apiClient = apiClient
    protected router = router
}
