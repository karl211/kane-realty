import BaseService from '../base.services'

const authService = class AuthService extends BaseService
{
    payments(params = {}){
        return super.get(`${this.baseURL}/payments`, params);
    }
};

export default authService
