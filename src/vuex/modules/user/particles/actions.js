import axios from "axios"

export default {
    REGISTER_REQUEST: ({ commit }, { username, password, confirmPassword, name, recaptchaToken }) => {
        return new Promise((resolve, reject) => {
            commit("REGISTER_REQUEST");
            var data = new URLSearchParams();
            data.append("username", username);
            data.append("password", password);
            data.append("confirmPassword", confirmPassword);
            data.append("name", name);
            data.append("g-recaptcha-response", recaptchaToken);
            axios.post('/api/registration', data)
                .then(resp => {
                    switch (resp.data.status) {
                        case "OK":
                            var token = resp.data.token;
                            localStorage.setItem('user-token', token);
                            axios.defaults.headers.common['Authorization'] = token;
                            commit("AUTH_SUCCESS", { token: token, profile: resp.data.profile });
                            resolve(resp.data);
                            break;
                        default:
                            commit("AUTH_ERROR", resp.data.status);
                            localStorage.removeItem('user-token');
                            reject(resp.data);
                            break;
                    }
                })
                .catch(err => {
                    commit("AUTH_ERROR", err);
                    localStorage.removeItem('user-token');
                    reject(err);
                })
        });
    },
    AUTH_REQUEST: ({ commit }, { username, password, recaptchaToken }) => {
        return new Promise((resolve, reject) => {
            commit("AUTH_REQUEST");
            var data = new URLSearchParams();
            data.append("username", username);
            data.append("password", password);
            data.append("g-recaptcha-response", recaptchaToken);
            axios.post('/api/autch', data)
                .then(resp => {
                    switch (resp.data.status) {
                        case "OK":
                            var token = resp.data.token;
                            localStorage.setItem('user-token', token);
                            axios.defaults.headers.common['Authorization'] = token;
                            commit("AUTH_SUCCESS", { token: token, profile: resp.data.profile });
                            resolve(resp.data);
                            break;
                        default:
                            commit("AUTH_ERROR", resp.data.status);
                            localStorage.removeItem('user-token');
                            reject(resp.data);
                    }
                })
                .catch(err => {
                    commit("AUTH_ERROR", err);
                    localStorage.removeItem('user-token');
                    reject(err);
                })
        });
    },
    AUTH_LOGOUT: ({ commit }) => {
        return new Promise((resolve) => {
            commit("AUTH_LOGOUT");
            localStorage.removeItem('user-token');
            delete axios.defaults.headers.common['Authorization'];
            resolve();
        })
    },
    PROFILE_REQUEST: ({ commit, dispatch }) => {
        return new Promise(() => {
            commit("PROFILE_REQUEST");
            axios.get('/api/user/getData/')
                .then(resp => {
                    switch (resp.data.status) {
                        case "OK":
                            commit("PROFILE_SUCCESS", resp.data.profile);
                            break;
                        default:
                            commit("PROFILE_ERROR", resp.data.status);
                            dispatch("AUTH_LOGOUT");

                    }
                })
                .catch((error) => {
                    commit("PROFILE_ERROR", error.message);
                    dispatch("AUTH_LOGOUT");
                })
        });
    },
}