export default {
    REGISTER_REQUEST: state => {
        state.status = "loading";
    },
    AUTH_REQUEST: state => {
        state.status = "loading";
    },
    AUTH_SUCCESS: (state, { token, profile }) => {
        state.status = "success";
        state.token = token;
        state.profile = profile;
    },
    AUTH_ERROR: state => {
        state.status = "error";
    },
    AUTH_LOGOUT: state => {
        state.token = null;
        state.profile = null;
    },
    PROFILE_SUCCESS: (state, profile) => {
        state.status = "success";
        state.profile = profile;
    },
    PROFILE_ERROR: (state, error) => {
        state.token = null;
        state.profile = null;
        state.status = error;
    }
}