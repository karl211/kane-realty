import BaseService from '../base.services'

const userService = class UserService extends BaseService
{
    all(params = {}){
        return super.get(`${this.baseURL}/users`, params);
    }

    employees(params = {}){
        return super.get(`${this.baseURL}/users/employees`, params);
    }

    removeUser(params = {}) {
        return super.post(`${this.baseURL}/users/delete`, params);
    }

    saveAccess(params = {}) {
        return super.post(`${this.baseURL}/users/permissions/save`, params);
    }
};

export default userService
