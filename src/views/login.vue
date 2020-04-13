<template>
  <section>
    <form id="login-form" @submit.prevent="login">
      <input v-model="username" type="text" name="login" placeholder="Логин" />
      <input v-model="password" type="password" name="password" placeholder="Пароль" />
      <button type="submit">Войти</button>
    </form>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data: function() {
    return {
      username: "",
      password: ""
    };
  },
  computed: {
    ...mapGetters(["IS_AUTHENTICATED"])
  },
  methods: {
    ...mapActions(["AUTH_REQUEST"]),
    login() {
      if (this.username.length && this.password.length) {
        const { username, password } = this;
        this.AUTH_REQUEST({ username, password }).then(() => {
          this.$router.push("/");
        });
      } else {
        alert("Введите логин и пароль");
      }
    }
  },
  mounted() {
    if (this.IS_AUTHENTICATED) {
      this.$router.push("/");
    }
  }
};
</script>

<style scoped>
form#login-form {
  margin: 150px auto 0 auto;
  display: grid;
  width: 250px;
  grid-gap: 15px;
}

#login-form > * {
  height: 40px;
  border-radius: 10px;
  border: unset;
}

#login-form > input {
  background-color: #efefef;
  padding: 0 10px;
}

#login-form > button {
  background-color: #1d85d0;
  color: white;
}
</style>