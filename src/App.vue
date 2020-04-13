<template>
  <div id="app" class="container">
    <myheader />
    <router-view></router-view>
  </div>
</template>

<script>
import myheader from "@/components/myheader/myheader.vue";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "App",
  components: {
    myheader
  },
  mounted: function() {
    if (this.IS_AUTHENTICATED) {
      this.PROFILE_REQUEST();
    }
  },
  computed: {
    ...mapGetters(["IS_AUTHENTICATED"])
  },
  methods: {
    ...mapActions(["PROFILE_REQUEST"])
  }
};
</script>

<style>
* {
  transition: all 0.3s ease-out;
  margin: 0;
  padding: 0;
}

body {
  font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande",
    "Lucida Sans", Arial, sans-serif;
  overflow-x: hidden;
}

.container {
  max-width: 100%;
  width: 1000px;
  margin: 0 auto 15px auto;
}

button {
  cursor: pointer;
}

/* .loader {
  position: absolute;
  width: 40px;
  top: calc(50% - 20px);
  left: calc(50% - 20px);
} */
</style>
