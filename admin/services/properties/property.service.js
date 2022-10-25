import BaseService from '../base.services'

const propertyService = class PropertyService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/locations`, params);
    }

    create(params = {}, header) {
        return super.post(`${this.baseURL}/properties`, params, header);
    }

    
};

export default propertyService
