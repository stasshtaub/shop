<template>
  <section class="catalog">
    <div v-if="true" id="items" class="items">
      <item
        class="item"
        v-for="item in checkedInCart"
        :key="item.pid"
        :item="item"
        @removeFromCart="REMOVE_FROM_CART(item)"
        @addToCart="addToCart(item)"
      ></item>
    </div>
    <div v-else-if="false">Ничего не найдено</div>
  </section>
</template>

<script>
import item from "./item.vue";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    item
  },
  props: {
    cart: Object
  },
  computed: {
    ...mapGetters(["PRODUCTS", "CART", "IS_AUTHENTICATED"]),
    checkedInCart() {
      if (this.CART) {
        var pidCartArray = [];
        this.CART.forEach(cartItem => {
          pidCartArray.push(cartItem.pid);
        });

        var result = [];
        this.PRODUCTS.forEach(catalogItem => {
          var indexInCart = pidCartArray.indexOf(catalogItem.pid);
          if (indexInCart != -1) {
            result.push({ ...catalogItem, indexInCart: indexInCart });
          } else {
            result.push(catalogItem);
          }
        });
        return result;
      }
      return this.PRODUCTS;
    }
  },
  methods: {
    ...mapActions(["GET_PRODUCTS_FROM_API", "ADD_TO_CART", "REMOVE_FROM_CART"]),
    addToCart(item) {
      if (this.IS_AUTHENTICATED) {
        this.ADD_TO_CART(item);
      } else {
        this.$router.push("/login");
      }
    }
  },
  mounted() {
    this.GET_PRODUCTS_FROM_API();
  }
};
</script>

<style scoped>
.catalog {
  margin-top: 40px;
  padding: 0 10px;
}
.items {
  display: grid;
  grid-template-columns: repeat(auto-fit, calc(50% - 20px));
  grid-gap: 40px;
}
@media only screen and (min-width: 725px) {
  .items {
    grid-template-columns: repeat(auto-fit, calc(100% / 3 - 80px / 3));
  }
}
@media only screen and (min-width: 1000px) {
  .items {
    grid-template-columns: repeat(auto-fit, calc(25% - 30px));
  }
}
</style>