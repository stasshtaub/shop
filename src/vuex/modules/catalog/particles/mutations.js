export default {
    SET_PRODUCTS: (state, products) => {
        state.products = products;
    },
    SET_FILTERS: (state, filters) => {
        state.filters = filters;
    },
    SET_SEARCH: (state, searchResult) => {
        state.searchResult = searchResult;
    }
}