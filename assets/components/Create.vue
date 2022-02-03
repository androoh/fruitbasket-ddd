<template>
  <div>
    <a @click="$router.push({ name: 'home' })" class="mb-4 d-block"
      >Back to Basket List</a
    >
    <div class="alert" :class="alert.type" v-if="alert">
      {{ alert.message }}
    </div>
    <h2>Create basket</h2>
    <form v-if="basket" @submit="update()">
      <div class="mb-3">
        <label for="basketName" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          id="basketName"
          required
          v-model="basket.name"
        />
      </div>
      <div class="mb-3">
        <label for="basketMaxCapacity" class="form-label">Max Capacity</label>
        <input
          type="text"
          class="form-control"
          id="basketMaxCapacity"
          required
          v-model="basket.maxCapacity"
        />
      </div>
      <button type="button" class="btn btn-success" @click="create()">
        Create basket
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import Table from "./Table.vue";

export default {
  components: {
    Table,
  },
  data() {
    return {
      alert: null,
      basket: {
        name: "",
        maxCapacity: "",
      },
    };
  },
  mounted() {},
  methods: {
    create() {
      if (this.basket.name && this.basket.maxCapacity) {
        axios
          .post(`/api/baskets`, this.basket)
          .then((response) => {
            this.alert = {
              type: "alert-success",
              message: "Successfully Created!",
            };
            this.alert = null;
            this.$router.push({ name: "home" });
          })
          .catch((error) => {
            this.alert = {
              type: "alert-danger",
              message: error.response.data,
            };
            setTimeout(() => (this.alert = null), 3000);
          });
      } else {
        this.alert = {
          type: "alert-danger",
          message: "Name and Max Capacity should not be empty",
        };
        setTimeout(() => (this.alert = null), 3000);
      }
    },
  },
};
</script>

<style>
</style>