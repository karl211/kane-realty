import BaseService from '../base.services'

const paymentService = class PaymentService extends BaseService
{
    create(params = {}, header) {
        return super.post(`${this.baseURL}/payments`, params, header);
    }

    remove(params = {}) {
        return super.post(`${this.baseURL}/payments/delete`, params);
    }
};

export default paymentService
