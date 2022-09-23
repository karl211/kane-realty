import accoutState from './account.state';
import accountGetters from './account.getters';
import accountMutations from './account.mutations';
import accountActions from './account.actions';

const state = () => accoutState

const getters = accountGetters

const mutations = accountMutations

const actions = accountActions

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
