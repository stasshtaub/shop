import mutations from './particles/mutations'
import actions from './particles/actions'
import getters from './particles/getters'

export default {
    state: {
        products: [],
        filters: {},
        searchResult: []
    },
    mutations,
    actions,
    getters
};