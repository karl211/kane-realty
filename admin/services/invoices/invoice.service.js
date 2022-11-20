import BaseService from '../base.services'

const invoiceService = class InvoiceService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/invoices`, params);
    }

    // create(params = {}) {
    //     return super.post(`${this.baseURL}/locations`, params);
    // }

    // branches(params = {}) {
    //     return super.get(`${this.baseURL}/branches`, params);
    // }
};

export default invoiceService
