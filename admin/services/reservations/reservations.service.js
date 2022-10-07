import BaseService from '../base.services'

const reservationsService = class ReservationsService extends BaseService
{
    allReservations(params = {}){
        return super.get(`${this.baseURL}/reservations`, params);
    }

    locations(params = {}){
        return super.get(`${this.baseURL}/locations`, params);
    }

    networks(params = {}){
        return super.get(`${this.baseURL}/networks`, params);
    }

    salesManager(params = {}){
        return super.get(`${this.baseURL}/sales-managers`, params);
    }

    create(params = {}, header){
        return super.post(`${this.baseURL}/reservations`, params, header);
    }
};

export default reservationsService
