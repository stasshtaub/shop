<template>
  <div class="main">
    <catalog />
  </div>
</template>

<script>
import catalog from "@/components/catalog/catalog.vue";

export default {
  name: "Main",
  components: {
    catalog
  }
};
</script>

<style scoped>
.loader {
  position: absolute;
  width: 40px;
  top: calc(50% - 20px);
  left: calc(50% - 20px);
}
</style>