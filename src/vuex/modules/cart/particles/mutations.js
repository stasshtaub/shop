export default {
    SET_CART: (state, cart) => {
        state.cart = cart;
    },
    ADD_TO_CART: (state, product) => {
        state.cart.push(product);
    },
    REMOVE_FROM_CART: (state, product) => {
        var index = state.cart.findIndex((cartItem) => {
            return cartItem.pid == product.pid;
        })
        state.cart.splice(index, 1)
    },
    CHANGE_CART_ITEM_COUNT: (state, { cartItem, newCount }) => {
        cartItem.quantity = newCount;
    }
}