import BaseService from '../base.services'

const expenseService = class ExpenseService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/reports/expenses`, params);
    }
    
};

export default expenseService
