import { Store } from 'vuex'

// eslint-disable-next-line import/no-mutable-exports
let $store

export function initializeStore (storeInstance) {
  $store = storeInstance
}

export { $store }
