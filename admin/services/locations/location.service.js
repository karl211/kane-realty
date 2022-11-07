import BaseService from '../base.services'

const locationService = class LocationService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/locations`, params);
    }

    create(params = {}) {
        return super.post(`${this.baseURL}/locations`, params);
    }

    branches(params = {}) {
        return super.get(`${this.baseURL}/branches`, params);
    }
};

export default locationService
