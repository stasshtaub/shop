<template>
  <div class="cart wrapper">
    <div class="cart-icon" @click="changeDispComponent">
      <div class="cart-icon__counter">
        <span>{{CART.length}}</span>
      </div>
    </div>
    <div class="cart-content" v-if="show">
      <template v-if="CART.length">
        <div class="cart-list">
          <cart-item
            v-for="(item, index) in CART"
            :key="item.pid"
            :cart_item="item"
            @remove="REMOVE_FROM_CART({pid:item.pid, indexInCart:index})"
            @changeCount="CHANGE_CART_ITEM_COUNT"
          />
        </div>
        <button class="order-button">Оформить заказ</button>
      </template>
      <p class="empty-cart" v-else>Корзина пуста</p>
    </div>
  </div>
</template>

<script>
import cartModule from "../../vuex/modules/cart/cartModule";
import { mapActions, mapGetters } from "vuex";
import cartItem from "./cart-item";

export default {
  name: "cart",
  props: {
    dispComponent: {
      type: Object,
      default() {
        return null;
      }
    }
  },
  components: {
    cartItem
  },
  computed: {
    ...mapGetters(["CART"]),
    show() {
      return this.dispComponent === this;
    }
  },
  methods: {
    ...mapActions([
      "GET_CART_FROM_API",
      "REMOVE_FROM_CART",
      "CHANGE_CART_ITEM_COUNT"
    ]),
    changeDispComponent() {
      this.$emit("changeDispComponent", this);
    }
  },
  beforeMount() {
    this.$store.registerModule("cartModule", cartModule);
    this.GET_CART_FROM_API();
  }
};
</script>

<style scoped>
.cart-content {
  z-index: 2;
  position: absolute;
  right: 0;
  top: 140%;
  width: 330px;
  padding: 20px;
  background: white;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 2px 5px #00000026;
}
.cart-icon {
  cursor: pointer;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-image: url(/assets/img/cart-icon.jpg);
  background-size: 100%;
}
.cart-icon__counter {
  position: absolute;
  left: 65%;
  padding: 5.5px 5.83px 5.5px 6.83px;
  border-radius: 10px;
  background-color: #2faef9;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
}
.cart-icon__counter > span {
  font-size: 14px;
  line-height: 9px;
}
.cart-list {
  display: grid;
  grid-gap: 20px;
}
.order-button {
  background-color: #1d85d0;
  color: white;
  padding: 11px 40px;
  border-radius: 10px;
  border: unset;
  margin: 20px auto 0 auto;
  display: block;
}
.empty-cart {
  color: #b9b9b9;
  text-align: center;
}
</style>