import store from './store'

export default {
    created: function () {
        if (store.getters.getRole == null) {
            store.dispatch('getRole')
        }
    }
}