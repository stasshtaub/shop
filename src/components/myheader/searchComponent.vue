<template>
  <div class="search-wrapper">
    <input
      class="search"
      type="search"
      name="search"
      placeholder="Поиск"
      v-model="search.query"
      @input="searchInput"
    />
    <div class="search-result" v-if="SEARCH_RESULT.length && show">
      <ul class="search-result__list">
        <li class="search-result__item" v-for="(item, i) in SEARCH_RESULT" :key="i">
          <img class="search-result__preview" :src="item.img" />
          <p class="search-result__name">{{item.name}}</p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "searchComponent",
  props: {
    dispComponent: {
      type: Object,
      default() {
        return null;
      }
    }
  },
  data: () => ({
    search: {
      query: ""
    }
  }),
  computed: {
    ...mapGetters(["SEARCH_RESULT"]),
    show() {
      return this.dispComponent === this;
    }
  },
  methods: {
    ...mapActions(["SEARCH"]),
    changeDispComponent() {
      this.$emit("changeDispComponent", this);
    },
    searchInput() {
      if (this.search.query) {
        this.SEARCH(this.search.query);
        if (this.dispComponent != this) {
          this.$emit("changeDispComponent", this);
        }
      } else {
        this.$emit("changeDispComponent", null);
      }
    }
  }
};
</script>

<style scoped>
input.search {
  height: 30px;
  border-radius: 10px;
  border: unset;
  background-color: whitesmoke;
  padding: 0 10px;
}

.search-result {
  position: absolute;
  left: 50%;
  transform: translate(-50%, 0);
  top: 51px;
  padding: 15px 10px;
  background-color: #ffffff;
  box-shadow: 0 2px 5px #00000038;
  width: 150px;
  border-radius: 10px;
}

.search-wrapper {
  position: relative;
}

ul.search-result__list {
  display: grid;
  grid-gap: 20px;
}

li.search-result__item {
  display: flex;
  align-items: center;
}

p.search-result__name {
  margin-left: 20px;
}

img.search-result__preview {
  width: 50px;
}
</style>