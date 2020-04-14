import axios from 'axios'
export default {
    GET_PRODUCTS_FROM_API({ commit }, filters = null) {
        return axios
            .get('/api/catalog/?filters=' + JSON.stringify(filters))
            .then(response => {
                var result = response.data;
                switch (result.status) {
                    case "OK":
                        commit('SET_PRODUCTS', result.data);
                        return result.data;
                    default:
                        console.log(result.status);
                }
            });
    },
    GET_FILTERS_FROM_API({ commit }) {
        return axios
            .get('/api/filter/')
            .then(response => {
                switch (response.data.status) {
                    case "OK":
                        commit('SET_FILTERS', response.data.filters);
                        break;
                    default:
                        console.log(response.data.status);
                }
            });
    }
}