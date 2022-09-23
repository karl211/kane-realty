export default {
    SET_IMPERSONATE(state: { impersonate: any }, payload: any) {
        state.impersonate = payload
    },
    setUser(state: { user: any }, data: any) {
        state.user = data
    },
    setUserStatus(state: { user: { attributes: { status: string } } }, data: any) {
        state.user.attributes.status = 'verified'
    },
    updateFirstName(state: { user: { attributes: { [x: string]: any } } }, data: any) {
        state.user.attributes['first-name'] = data
    },
    updateLastName(state: { user: { attributes: { [x: string]: any } } }, data: any) {
        state.user.attributes['last-name'] = data
    },
    setAuthUser(state: { authUser: any }, data: any) {
        state.authUser = data
    },
    setDefaultCreditCard(state: { defaultCreditCard: any }, data: any) {
        state.defaultCreditCard = data
    },
    setPayments(state: { payments: any }, data: any) {
        state.payments = data
    },
    setSubscriptions(state: { subscriptions: any }, data: any) {
        state.subscriptions = data
    },

    SET_NOTIFICATIONS: (state: {notifications: any}, payload: any) => state.notifications = payload,

    SET_MARK_READ: (state: {notifications: any}, payload: any) => {
      let index = state.notifications.findIndex((v:any)=> v.id === payload.id);
      state.notifications[index] = payload
    },

    SET_MARK_READ_ALL: (state: {notifications: any}, payload: any) => {
      payload.forEach( (item:any)=> {
        let index = state.notifications.findIndex((v:any)=> v.id === item.id);
        state.notifications[index] = item
      });
    },


}
