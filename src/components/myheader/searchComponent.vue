<template>
  <div class="search-wrapper">
    <input
      class="search"
      type="search"
      name="search"
      placeholder="Поиск"
      v-model="search.query"
      @input="gosearch"
    />
    <div class="search-result" v-if="search.result.length && dispСomponent==$options.name">
      <ul class="search-result__list">
        <li class="search-result__item" v-for="(item, i) in search.result" :key="i">
          <img class="search-result__preview" :src="item.img" />
          <p class="search-result__name">{{item.name}}</p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: {
    dispСomponent: String
  },
  data: function() {
    return {
      search: {
        query: "",
        result: []
      }
    };
  },
  methods: {
    gosearch: function() {
      if (this.search.query) {
        axios
          .get("/api/", {
            params: {
              controller: "catalog",
              action: "search",
              data: [this.search.query]
            }
          })
          .then(response => {
            switch (response.data.status) {
              case "OK":
                this.search.result = response.data.data;
                break;
              default:
                console.log(response.data.status);
            }
          })
          .catch(error => {
            console.log(error);
          });
      } else {
        this.search.result = [];
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