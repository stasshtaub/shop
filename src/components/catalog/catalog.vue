<template>
  <section class="catalog">
    <div class="filters">
      <div class="filters__wrapper filter" v-for="(filter, key) in FILTERS" :key="key">
        <p class="filter__placeholder" @click.self="showFilter=key">{{filters[key] || filter.name}}</p>
        <div class="filter__values" v-if="showFilter===key">
          <p class="filter__value" @click.self="selectFilter(key, null)">Все</p>
          <p
            class="filter__value"
            v-for="value in filter.values"
            :key="value.name"
            @click="selectFilter(key, value.name)"
          >{{value.name}}</p>
        </div>
      </div>
      <button class="filters__btn" @click="GET_PRODUCTS_FROM_API(selectedFilters())">Отфильтровать</button>
    </div>
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
  data() {
    return {
      showFilter: "",
      filters: {}
    };
  },
  computed: {
    ...mapGetters(["PRODUCTS", "FILTERS", "CART", "IS_AUTHENTICATED"]),
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
    ...mapActions([
      "GET_PRODUCTS_FROM_API",
      "GET_FILTERS_FROM_API",
      "ADD_TO_CART",
      "REMOVE_FROM_CART"
    ]),
    addToCart(item) {
      if (this.IS_AUTHENTICATED) {
        this.ADD_TO_CART(item);
      } else {
        this.$router.push("/login");
      }
    },
    selectFilter(filterKey, value) {
      this.filters[filterKey] = value;
      this.showFilter = "";
    },
    selectedFilters() {
      let result = {};
      for (let key in this.filters) {
        if (this.filters[key]) {
          result[key] = this.filters[key];
        }
      }
      return result;
    }
  },
  mounted() {
    this.GET_PRODUCTS_FROM_API();
    this.GET_FILTERS_FROM_API();
  }
};
</script>

<style>
.catalog {
  margin-top: 40px;
  padding: 0 10px;
}
.items {
  display: grid;
  grid-template-columns: repeat(auto-fit, calc(50% - 20px));
  grid-gap: 40px;
  margin-top: 40px;
}

.filters {
  display: flex;
}
.filters > * {
  width: 150px;
  border-radius: 10px;
}
.filters > *:not(:last-child) {
  margin-right: 20px;
}
.filters__wrapper {
  position: relative;
}
.filters__wrapper > * {
  border-radius: 10px;
  background-color: #f5f5f5;
}
.filters__wrapper {
  color: #a07171;
}
.filter__placeholder {
  padding: 0 15px;
  height: 100%;
  display: flex;
  align-items: center;
  cursor: pointer;
}
.filter__values {
  position: absolute;
  width: 100%;
  top: 0;
  overflow: hidden;
}
.filter__value {
  padding: 0 15px;
  height: 40px;
  display: flex;
  align-items: center;
  cursor: pointer;
}
.filter__value:hover {
  background-color: #e6e6e6;
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