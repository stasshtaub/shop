<template>
  <section>
    <form @submit.prevent="register">
      <div class="input-wrapper">
        <div class="errorTooltip" v-if="errors.name">{{errors.name}}</div>
        <input v-model="name" type="text" name="name" placeholder="Имя" />
      </div>
      <div class="input-wrapper">
        <div class="errorTooltip" v-if="errors.username">{{errors.username}}</div>
        <input v-model="username" type="text" name="login" placeholder="Логин" />
      </div>
      <div class="input-wrapper">
        <div class="errorTooltip" v-if="errors.password">{{errors.password}}</div>
        <input v-model="password" type="password" name="password" placeholder="Пароль" />
      </div>
      <div class="input-wrapper">
        <div class="errorTooltip" v-if="errors.confirmPassword">{{errors.confirmPassword}}</div>
        <input
          v-model="confirmPassword"
          type="password"
          name="confirmPassword"
          placeholder="Подтверждение пароля"
        />
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
      <button type="submit">Зарегистрироваться</button>
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
      name: "",
      username: "",
      password: "",
      confirmPassword: "",
      errors: {
        name: null,
        username: null,
        password: null,
        confirmPassword: null,
        captcha: null
      },
      recaptchaToken: null
    };
  },
  computed: {
    ...mapGetters(["IS_AUTHENTICATED"])
  },
  methods: {
    ...mapActions(["REGISTER_REQUEST"]),
    validate() {
      for (let key in this.errors) {
        this.errors[key] = null;
      }
      if (!this.name.length) {
        this.errors.name = "Введите имя";
      }
      if (this.username.length < 6) {
        this.errors.username = "Минимум 6 символов";
      }
      if (this.password.length < 6) {
        this.errors.password = "Минимум 6 символов";
      } else if (this.password != this.confirmPassword) {
        this.errors.confirmPassword = "Пароли не совпадают";
      }
      if (!window.grecaptcha.getResponse()) {
        this.errors.captcha = "Подтвердите, что вы не робот";
      }
      return (
        !this.errors.name &&
        !this.errors.username &&
        !this.errors.password &&
        !this.errors.confirmPassword &&
        !this.errors.captcha
      );
    },
    captchaVerifyHandler(recaptchaToken) {
      this.recaptchaToken = recaptchaToken;
    },
    register() {
      if (this.validate()) {
        const {
          username,
          password,
          confirmPassword,
          name,
          recaptchaToken
        } = this;
        this.REGISTER_REQUEST({
          username,
          password,
          confirmPassword,
          name,
          recaptchaToken
        })
          .then(() => {
            this.$router.push("/");
          })
          .catch(data => {
            switch (data.status) {
              case "VALIDATE_ERROR":
                if (data.errors.username) {
                  this.errors.username = data.errors.username;
                }
                if (data.errors.password) {
                  this.errors.password = data.errors.password;
                } else if (data.errors.confirmPassword) {
                  this.errors.confirmPassword = data.errors.confirmPassword;
                }
                if (data.errors.name) {
                  this.errors.name = data.errors.name;
                }
                if (data.errors.captcha) {
                  this.errors.captcha = data.errors.captcha;
                  this.$refs.vuerecaptcha.reset();
                }
                break;
              case "USER_ALREADY_EXIST":
                this.errors.username = "Такой пользователь уже существует";
                break;
            }
          });
      }
    },
    onCaptchaExpired() {
      this.errors.captcha = "Неверная каптча";
      this.$refs.vuerecaptcha.reset();
    }
  },
  mounted() {
    if (this.IS_AUTHENTICATED) {
      this.$router.push("/");
    }
  },
  created() {}
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
</style>