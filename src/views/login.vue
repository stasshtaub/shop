<template>
  <section>
    <form id="login-form" @submit.prevent="login">
      <div class="generalError" v-if="errors.generalError">{{errors.generalError}}</div>
      <div class="input-wrapper">
        <div class="errorTooltip" v-if="errors.username">{{errors.username}}</div>
        <input v-model="username" type="text" name="login" placeholder="Логин" />
      </div>
      <div class="input-wrapper">
        <div class="errorTooltip" v-if="errors.password">{{errors.password}}</div>
        <input v-model="password" type="password" name="password" placeholder="Пароль" />
      </div>
      <div class="input-wrapper">
        <div class="errorTooltip" v-if="errors.captcha">{{errors.captcha}}</div>
        <vuerecaptcha
          sitekey="6LeheekUAAAAAPC5nUZ5g7udzHEpqYT77PQLmDyL"
          :loadRecaptchaScript="true"
          @verify="captchaVerifyHandler"
          @expired="onCaptchaExpired"
        ></vuerecaptcha>
      </div>
      <button type="submit">Войти</button>
    </form>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import vuerecaptcha from "vue-recaptcha";

export default {
  components: {
    vuerecaptcha
  },
  data: function() {
    return {
      username: "",
      password: "",
      errors: {
        generalError: null,
        username: null,
        password: null,
        captcha: null
      },
      recaptchaToken: null
    };
  },
  computed: {
    ...mapGetters(["IS_AUTHENTICATED"])
  },
  methods: {
    ...mapActions(["AUTH_REQUEST"]),
    validate() {
      for (let key in this.errors) {
        this.errors[key] = null;
      }
      if (!window.grecaptcha) {
        this.errors.generalError = "Проверьте подключение к интернету";
      } else {
        if (!this.username.length) {
          this.errors.username = "Введите логин";
        }
        if (!this.password.length) {
          this.errors.password = "Введите пароль";
        }
        if (!window.grecaptcha.getResponse()) {
          this.errors.captcha = "Подтвердите, что вы не робот";
        }
      }
      return (
        !this.errors.username && !this.errors.password && !this.errors.captcha
      );
    },
    captchaVerifyHandler(recaptchaToken) {
      this.recaptchaToken = recaptchaToken;
    },
    onCaptchaExpired() {
      this.errors.captcha = "Неверная каптча";
      window.grecaptcha.reset();
    },
    login() {
      if (this.validate()) {
        const { username, password, recaptchaToken } = this;
        this.AUTH_REQUEST({ username, password, recaptchaToken })
          .then(() => {
            this.$router.push("/");
          })
          .catch(data => {
            window.grecaptcha.reset();
            switch (data.status) {
              case "VALIDATE_ERROR":
                if (data.errors.username) {
                  this.errors.username = data.errors.username;
                }
                if (data.errors.password) {
                  this.errors.password = data.errors.password;
                }
                if (data.errors.captcha) {
                  this.errors.captcha = data.errors.captcha;
                }
                break;
              case "USER_NOT_FOUND":
                this.errors.username = "Неправильный логин и/или пароль";
                break;
              default:
                console.log(data.status);
            }
          });
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
form {
  margin: 150px auto 0 auto;
  display: grid;
  width: 250px;
  grid-gap: 15px;
}

input,
button {
  height: 40px;
  border-radius: 10px;
  border: unset;
}

form input {
  background-color: #efefef;
  padding: 0 10px;
  width: calc(100% - 20px);
}

form > button {
  background-color: #1d85d0;
  color: white;
}

.input-wrapper {
  position: relative;
}

.errorTooltip {
  width: max-content;
  position: absolute;
  display: flex;
  align-items: center;
  left: 100%;
  height: 100%;
  margin-left: 10px;
  padding: 0 20px;
  background-color: #ff5454;
  color: #fff;
  font-size: 0.8rem;
  text-align: center;
  border-radius: 10px;
}
.generalError {
  display: flex;
  align-items: center;
  padding: 10px 20px;
  line-height: 1.4rem;
  background-color: #ff5454;
  color: #fff;
  font-size: 0.8rem;
  text-align: center;
  border-radius: 10px;
}
</style>