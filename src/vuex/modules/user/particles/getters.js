export default {
    IS_AUTHENTICATED: state => !!state.token,
    GET_PROFILE: state => state.profile,
}