import BaseService from '../base.services'

const dashboardService = class DashboardService extends BaseService
{
    statuses(params = {}){
        return super.get(`${this.baseURL}/dashboard/statuses`, params);
    }
    
};

export default dashboardService
