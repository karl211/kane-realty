import BaseService from '../base.services'

const calendarService = class CalendarService extends BaseService
{
    pastDues(params = {}){
        return super.get(`${this.baseURL}/calendar/past-dues`, params);
    }

    // create(params = {}) {
    //     return super.post(`${this.baseURL}/locations`, params);
    // }

    // branches(params = {}) {
    //     return super.get(`${this.baseURL}/branches`, params);
    // }
};

export default calendarService
