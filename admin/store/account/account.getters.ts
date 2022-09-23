export default {
    getUser(state: { user: any }) {
        return state.user;
    },

    getAuthUser(state: { authUser: any }) {
        return state.authUser;
    },

    getDefaultCreditCard(state: { defaultCreditCard: any }) {
        return state.defaultCreditCard;
    },

    getPayments(state: { payments: any }) {
        return state.payments;
    },

    getSubscriptions(state: { subscriptions: any }) {
        return state.subscriptions;
    },


    isImpersonate: (state: any)=> state.impersonate,

    notifications: (state: any) => state.notifications

}
