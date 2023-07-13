import BaseService from '../base.services'

const propertyService = class PropertyService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/locations`, params);
    }

    locationProperties(params = {}, location){
        return super.get(`${this.baseURL}/locations/${location}/properties`, params);
    }

    update(property, params = {}){
        return super.post(`${this.baseURL}/properties/${property}`, params);
    }

    delete(property, params = {}){
        return super.post(`${this.baseURL}/properties/${property}/delete`, params);
    }

    updateStatus(property, params = {}){
        return super.post(`${this.baseURL}/properties/${property}/status`, params);
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
