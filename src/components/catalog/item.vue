<template>
  <div>
    <div class="item__image" :style="{ 'background-image': `url('${item.img}')`}"></div>
    <div class="item__description">
      <p class="item__name">{{item.name}}</p>
      <p class="item__price">{{item.price}}р</p>
    </div>
    <button
      class="item__button"
      :class="{'in-cart':inCart}"
      @click="$emit(inCart?'removeFromCart':'addToCart')"
    >{{inCart?"В корзине":"+ В корзину"}}</button>
  </div>
</template>

<script>
export default {
  props: {
    item: Object
  },
  computed: {
    inCart() {
      return "indexInCart" in this.item;
    }
  }
};
</script>

<style scoped>
.item {
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
}

.item__image {
  background-size: cover;
  background-position: 50%;
  padding-bottom: 100%;
}

.item__description {
  margin-top: 15px;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
}

p.item__name {
  color: #737171;
}

.item__button {
  background-color: #1d85d0;
  color: white;
  height: 40px;
  width: 100%;
  border: unset;
  margin-top: 15px;
}

.item__button.in-cart {
  content: "В корзине";
  background-color: #84ce14;
}
</style>