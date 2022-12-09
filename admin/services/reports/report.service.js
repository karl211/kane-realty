import BaseService from '../base.services'

const reportService = class ReportService extends BaseService
{
    sales(params = {}){
        return super.get(`${this.baseURL}/reports/sales`, params);
    }
    
};

export default reportService
