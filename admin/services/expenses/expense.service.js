import BaseService from '../base.services'

const expenseService = class ExpenseService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/reports/expenses`, params);
    }

    create(params = {}, header) {
        return super.post(`${this.baseURL}/reports/expenses`, params, header);
    }
    
};

export default expenseService
