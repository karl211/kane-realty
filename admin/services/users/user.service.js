import BaseService from '../base.services'

const userService = class UserService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/users`, params);
    }

    removeUser(params = {}) {
        return super.post(`${this.baseURL}/users/delete`, params);
    }
};

export default userService
