import BaseService from '../base.services'

const reservationsService = class ReservationsService extends BaseService
{
    locations(params = {}){
        return super.get(`${this.baseURL}/locations`, params);
    }

    networks(params = {}){
        return super.get(`${this.baseURL}/networks`, params);
    }

    salesManager(params = {}){
        return super.get(`${this.baseURL}/sales-managers`, params);
    }
};

export default reservationsService
