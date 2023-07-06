import BaseService from '../base.services'

const propertyService = class PropertyService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/locations`, params);
    }

    locationProperties(params = {}, location){
        return super.get(`${this.baseURL}/locations/${location}/properties`, params);
    }

    getLots(params = {}, location){
        return super.get(`${this.baseURL}/locations/${location}/lots`, params);
    }
    

    create(params = {}, header) {
        return super.post(`${this.baseURL}/properties`, params, header);
    }

    statuses(params = {}){
        return super.get(`${this.baseURL}/properties/statuses`, params);
    }
};

export default propertyService
