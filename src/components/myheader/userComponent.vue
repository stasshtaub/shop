<template>
  <div class="wrapper">
    <div
      class="profile-icon"
      :style="{'background-image': 'url('+GET_PROFILE.avatar+')'}"
      @click="changeDispComponent"
    ></div>
    <div class="profile-info" v-if="show">
      <img class="profile__avatar" :src="GET_PROFILE.avatar" />
      <p>Имя: {{GET_PROFILE.name}}</p>
      <p>Логин: {{GET_PROFILE.login}}</p>
      <a href id="logout" @click.prevent="logout">Выйти</a>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "userComponent",
  props: {
    dispComponent: {
      type: Object,
      default() {
        return null;
      }
    }
  },
  methods: {
    ...mapActions(["AUTH_REQUEST", "AUTH_LOGOUT"]),
    logout() {
      this.AUTH_LOGOUT();
      this.$store.unregisterModule("cartModule");
    },
    changeDispComponent() {
      this.$emit("changeDispComponent", this);
    }
  },
  computed: {
    ...mapGetters(["GET_PROFILE", "IS_AUTHENTICATED"]),
    show() {
      return this.dispComponent === this;
    }
  }
};
</script>

<style scoped>
.profile-icon {
  cursor: pointer;
  position: relative;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-size: 120% 120%;
  background-position: center;
}
.profile-info {
  position: absolute;
  right: 0;
  top: 140%;
  padding: 15px 10px;
  width: 150px;
  display: grid;
  grid-gap: 15px;
  background: white;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 2px 5px #00000026;
}
.profile-info > p,
.profile-info > #logout {
  padding: 5px;
  background-color: #ffffff;
  border-radius: 5px;
  text-align: center;
  margin: 0;
}
.profile-info > .profile__avatar {
  width: 100%;
  border-radius: 5px;
}
.profile-info > #logout {
  background-color: #ff3362;
  color: white;
}
a#logout {
  text-decoration: none;
}
</style>