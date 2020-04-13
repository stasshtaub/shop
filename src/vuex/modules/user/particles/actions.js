import axios from "axios"

export default {
    REGISTER_REQUEST: ({ commit }, { username, password, confirmPassword, name }) => {
        return new Promise((resolve, reject) => {
            commit("REGISTER_REQUEST");
            var data = new URLSearchParams();
            data.append("username", username);
            data.append("password", password);
            data.append("confirmPassword", confirmPassword);
            data.append("name", name);
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
    AUTH_REQUEST: ({ commit }, { username, password }) => {
        return new Promise((resolve, reject) => {
            commit("AUTH_REQUEST");
            var data = new URLSearchParams();
            data.append("username", username);
            data.append("password", password);
            axios.post('/api/autch', data)
                .then(resp => {
                    const token = resp.data.token;
                    localStorage.setItem('user-token', token);
                    axios.defaults.headers.common['Authorization'] = token;
                    commit("AUTH_SUCCESS", { token: token, profile: resp.data.profile });
                    resolve(resp);
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
                    commit("PROFILE_SUCCESS", resp.data.profile);
                })
                .catch((error) => {
                    commit("PROFILE_ERROR", error.message);
                    dispatch("AUTH_LOGOUT");
                })
        });
    },
}