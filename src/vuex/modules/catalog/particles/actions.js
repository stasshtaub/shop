import axios from 'axios'
export default {
    GET_PRODUCTS_FROM_API({ commit }) {
        return axios
            .get("/api/catalog/")
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
    }
}