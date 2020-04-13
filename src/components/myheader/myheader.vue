<template>
  <header>
    <link v-if="darkMode" rel="stylesheet" href="/assets/styles/dark.css" />
    <div class="left-panel">
      <input type="checkbox" id="checkbox-dark" v-model="darkMode" @change="toggleDarkMode" />
      <label for="checkbox-dark"></label>
    </div>
    <div class="right-panel">
      <searchComponent />
      <userComponent
        v-if="GET_PROFILE"
        :dispComponent="dispComponent"
        @changeDispComponent="changeDispComponent"
      />
      <cart
        v-if="IS_AUTHENTICATED"
        :dispComponent="dispComponent"
        @changeDispComponent="changeDispComponent"
      />
      <template v-else>
        <router-link id="login" to="/login">Войти</router-link>
        <router-link id="signup" to="/signup">Зарегистрироваться</router-link>
      </template>
    </div>
  </header>
</template>

<script>
import { mapGetters } from "vuex";
import userComponent from "./userComponent.vue";
import cart from "../cart/cart";
import searchComponent from "./searchComponent.vue";
export default {
  data() {
    return {
      darkMode: localStorage.getItem("darkModeActive") == "true" || false,
      dispComponent: null
    };
  },
  components: {
    userComponent,
    cart,
    searchComponent
  },
  computed: {
    ...mapGetters(["IS_AUTHENTICATED", "GET_PROFILE"])
  },
  methods: {
    toggleDarkMode() {
      console.log("toggleDarkMode");
      localStorage.setItem("darkModeActive", this.darkMode);
    },
    changeDispComponent(component) {
      if (this.dispComponent != component) {
        this.dispComponent = component;
      } else {
        this.dispComponent = null;
      }
    }
  }
};
</script>

<style scoped>
header {
  margin: 0 calc(50% - 50vw);
  height: 50px;
  padding: 0 calc(50vw - 50% + 10px);
  background-color: #fff;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.08);
}

.wrapper {
  position: relative;
}

.left-panel,
.right-panel {
  height: 100%;
  display: flex;
  align-items: center;
}

.left-panel {
  float: left;
}

.right-panel {
  float: right;
}

.right-panel > *:not(:last-child) {
  margin-right: 20px;
}

a#login,
a#signup {
  text-decoration: none;
}

#checkbox-dark {
  position: absolute;
  z-index: -1;
  opacity: 0;
}
#checkbox-dark + label {
  position: relative;
  cursor: pointer;
}
#checkbox-dark + label:before {
  content: "";
  position: absolute;
  top: -13px;
  left: 0;
  width: 50px;
  height: 26px;
  border-radius: 13px;
  background: #cdd1da;
  transition: 0.2s;
}
#checkbox-dark + label:after {
  content: "";
  position: absolute;
  top: -11px;
  left: 2px;
  width: 22px;
  height: 22px;
  border-radius: 10px;
  background: #fff;
  transition: 0.2s;
}
#checkbox-dark:checked + label:before {
  background: #1f1b24;
}
#checkbox-dark:checked + label:after {
  left: 26px;
  background-color: #1d85d0;
}
</style>