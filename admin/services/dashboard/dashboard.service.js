import BaseService from '../base.services'

const dashboardService = class DashboardService extends BaseService
{
    // create(params = {}, header) {
    //     return super.post(`${this.baseURL}/payments`, params, header);
    // }

    // remove(params = {}) {
    //     return super.post(`${this.baseURL}/payments/delete`, params);
    // }

    statuses(params = {}){
        return super.get(`${this.baseURL}/dashboard/statuses`, params);
    }
    
};

export default dashboardService
