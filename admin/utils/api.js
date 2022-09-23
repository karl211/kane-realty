// eslint-disable-next-line import/no-mutable-exports
let $axios

export function initializeAxios (axiosInstance) {
  $axios = axiosInstance
}

export { $axios }
