<template>
  <div class="cart-item">
    <div class="img-wrapper">
      <img class="cart-item__img" :src="cart_item.img" />
    </div>
    <div class="cart-item__info">
      <p class="cart-item__name">{{cart_item.name}}</p>
      <p class="cart-item__price">{{cart_item.price*cart_item.quantity}}р.</p>
    </div>
    <div class="cart-item__controls">
      <div class="cart_item_count-wrapper">
        <button class="cart-item__count-minus" @click="changeCount(cart_item.quantity-1)">-</button>
        <input class="cart-item__count" type="number" v-model="cart_item.quantity" />
        <button class="cart-item__count-plus" @click="changeCount(parseInt(cart_item.quantity)+1)">+</button>
      </div>
      <button class="cart-item__delete" @click="$emit('remove')">x</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "cart-item",
  props: {
    cart_item: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  mounted() {
    if (!this.cart_item.quantity) {
      this.$set(this.cart_item, "quantity", 1);
    }
  },
  methods: {
    changeCount(newCount) {
      this.$emit("changeCount", {
        cartItem: this.cart_item,
        newCount: newCount
      });
    }
  }
};
</script>

<style scoped>
.cart-item {
  list-style-type: none;
  display: flex;
  align-items: center;
}
.cart-item__info {
  margin-left: 20px;
}
.img-wrapper {
  width: 60px;
  height: 60px;
  border-radius: 5px;
  overflow: hidden;
}
img.cart-item__img {
  width: 100%;
  flex-shrink: 0;
}
input.cart-item__count::-webkit-inner-spin-button {
  display: none;
}
input.cart-item__count {
  -moz-appearance: textfield;
}
.cart-item__controls {
  display: flex;
  margin-left: auto;
}
.cart-item__controls button {
  width: 25px;
  height: 25px;
  border: none;
  border-radius: 5px;
  background-color: #efefef;
}
.cart-item__delete {
  margin-left: 10px;
}
input.cart-item__count {
  width: 25px;
  border: unset;
  text-align: center;
}
</style>