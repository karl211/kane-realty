import BaseService from '../base.services'

const reservationsService = class ReservationsService extends BaseService
{
    allReservations(params = {}) {
        return super.get(`${this.baseURL}/reservations`, params);
    }

    locations(params = {}) {
        return super.get(`${this.baseURL}/reservations/locations`, params);
    }

    networks(params = {}) {
        return super.get(`${this.baseURL}/networks`, params);
    }

    salesManager(params = {}) {
        return super.get(`${this.baseURL}/sales-managers`, params);
    }

    create(params = {}, header) {
        return super.post(`${this.baseURL}/reservations`, params, header);
    }

    getBuyer(buyer) {
        return super.get(`${this.baseURL}/reservations/${buyer}`);
    }

    addProperty(buyer, params = {}) {
        return super.post(`${this.baseURL}/reservations/${buyer}/property`, params);
    }

    updateDocument(buyer, params = {}) {
        return super.post(`${this.baseURL}/reservations/${buyer}/document`, params);
    }

    getDocuments() {
        return super.get(`${this.baseURL}/documents`);
    }

    download(url, params = {}) {
        return super.get(url, params);
    }

    
};

export default reservationsService
