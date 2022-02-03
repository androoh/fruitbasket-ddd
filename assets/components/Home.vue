<template>
  <div>
    <div class="alert" :class="alert.type" v-if="alert">
      {{ alert.message }}
    </div>
    <h2>Baskets list</h2>
    <button
      type="button"
      class="btn btn-primary float-end"
      @click="$router.push({ name: 'basket_create' })"
    >
      Create basket
    </button>
    <Table
      :items="baskets"
      :columns="columns"
      @delete-event="removeBasket"
    ></Table>
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
      columns: [
        {
          prop: "name",
          title: "Name",
        },
        {
          prop: "maxCapacity",
          title: "Max Capacity",
        },
      ],
      baskets: [],
      alert: null,
    };
  },
  mounted() {
    this.fetchBaskets();
  },
  methods: {
    fetchBaskets() {
      axios
        .get("/api/baskets")
        .then((response) => (this.baskets = response.data))
        .catch((error) => {
          this.alert = {
            type: "alert-danger",
            message: error.response.data,
          };
          setTimeout(() => (this.alert = null), 3000);
        });
    },
    removeBasket(id) {
      axios
        .delete(`/api/baskets/${id}`)
        .then((response) => {
          this.fetchBaskets();
          this.alert = {
            type: "alert-success",
            message: "Basket Successfully Deleted!",
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