// import { Plugin } from '@nuxt/types'
import AccountService from '../services/account'
// import ApplicationService from '../services/SOLO/application.service'

// interface Services {
//   $accountService: AccountService
// }

// declare module 'vue/types/vue' {
//   interface Vue extends Services {}
// }

// declare module '@nuxt/types' {
//   interface NuxtAppOptions extends Services {}
// }

// declare module 'vuex/types/index' {
//   // eslint-disable-next-line @typescript-eslint/no-unused-vars
//   interface Store<S> extends Services {}
// }

const servicesPlugin = (_context, inject) => {
  inject('accountService', new AccountService())
}

export default servicesPlugin

