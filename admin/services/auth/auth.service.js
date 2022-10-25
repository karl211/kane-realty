import BaseService from '../base.services'

const authService = class AuthService extends BaseService
{
    user(params = {}){
        return super.get(`${this.baseURL}/user`, params);
    }

    branch(params = {}){
        return super.get(`${this.baseURL}/branches`, params);
    }

    payments(params = {}){
        return super.get(`${this.baseURL}/payments`, params);
    }

    searchBuyer(params = {}){
        return super.get(`${this.baseURL}/users/search`, params);
    }
};

export default authService
