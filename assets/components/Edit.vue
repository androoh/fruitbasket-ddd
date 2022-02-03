<template>
  <div>
    <a @click="$router.push({ name: 'home' })" class="mb-4 d-block">Back to Basket List</a>
    <div class="alert" :class="alert.type" v-if="alert">
      {{ alert.message }}
    </div>
    <h2>Edit basket</h2>
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
      <button type="button" class="btn btn-success" @click="update()">
        Update basket
      </button>
      <button
        type="button"
        class="btn btn-danger float-end"
        @click="clearItems()"
      >
        Clear items
      </button>
      <button
        type="button"
        class="btn btn-success float-end me-2"
        @click="
          $router.push({ name: 'basket_items', params: { id: basket.id } })
        "
      >
        Add items
      </button>
      <Table
        :items="basket.items"
        :columns="columns"
        :showActions="false"
      ></Table>
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
      basketId: 0,
      alert: null,
      basket: null,
      columns: [
        {
          prop: "type",
          title: "Type",
        },
        {
          prop: "weight",
          title: "Weight",
        },
      ],
    };
  },
  created() {
    this.basketId = this.$route.params.id;
  },
  mounted() {
    if (this.basketId) {
      this.fetchBasket();
    }
  },
  methods: {
    fetchBasket() {
      axios
        .get(`/api/baskets/${this.basketId}/items`)
        .then((response) => (this.basket = response.data))
        .catch((error) => {
          this.alert = {
            type: "alert-danger",
            message: error.response.data,
          };
          setTimeout(() => (this.alert = null), 3000);
        });
    },
    update() {
      if (this.basket.name) {
        axios
          .put(`/api/baskets/${this.basketId}`, { name: this.basket.name })
          .then((response) => {
            this.alert = {
              type: "alert-success",
              message: "Successfully Updated!",
            };
            setTimeout(() => (this.alert = null), 3000);
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
          message: "Name should not be empty",
        };
        setTimeout(() => (this.alert = null), 3000);
      }
    },
    clearItems() {
      axios
        .delete(`/api/baskets/${this.basketId}/items`)
        .then((response) => {
          this.basket.items = [];
          this.fetchBasket();
          this.alert = {
            type: "alert-success",
            message: "Items Successfully Deleted!",
          };
          setTimeout(() => (this.alert = null), 3000);
        })
        .catch((error) => {
          this.alert = {
            type: "alert-danger",
            message: error.response.data,
          };
          setTimeout(() => (this.alert = null), 3000);
        });
    },
  },
};
</script>

<style>
</style>