import axios from 'axios'

export default {
    GET_CART_FROM_API({ commit }) {
        return axios
            .get("/api/cart/")
            .then(response => {
                switch (response.data.status) {
                    case "OK":
                        commit('SET_CART', response.data.items);
                        break;
                    default:
                        console.log(response.data.status);
                }
            });
    },
    ADD_TO_CART({ commit }, product) {
        return new Promise((resolve, reject) => {
            axios
                .post("/api/cart/", `pid=${product.pid}`)
                .then(response => {
                    switch (response.data.status) {
                        case "OK":
                            commit('ADD_TO_CART', response.data.item);
                            resolve();
                            break;
                        default:
                            reject(response.data.status);
                    }
                });
        })
    },
    REMOVE_FROM_CART({ commit }, product) {
        return new Promise((resolve, reject) => {
            axios
                .delete("/api/cart/", { params: { pid: product.pid } })
                .then(response => {
                    var result = response.data;
                    switch (result.status) {
                        case "OK":
                            commit('REMOVE_FROM_CART', product);
                            resolve();
                            break;
                        default:
                            reject(result.status);
                    }
                });
        })
    },
    CHANGE_CART_ITEM_COUNT({ commit }, { cartItem, newCount }) {
        if (1 <= newCount && newCount <= cartItem.count_product) {
            axios
                .patch("/api/cart/", `pid=${cartItem.pid}&newCount=${newCount}`)
                .then(response => {
                    var result = response.data;
                    switch (result.status) {
                        case "OK":
                            commit('CHANGE_CART_ITEM_COUNT', { cartItem, newCount });
                            break;
                        default:
                            console.log("Ошибка: " + result.status);
                    }
                });
        }
    }
}