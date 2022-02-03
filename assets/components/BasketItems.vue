<template>
  <div>
    <a
      @click="$router.push({ name: 'edit', params: { id: basketId } })"
      class="mb-4 d-block"
      >Back to Basket Edit</a
    >
    <div class="alert" :class="alert.type" v-if="alert">
      {{ alert.message }}
    </div>
    <h2>Basket items</h2>
    <div class="mb-4" v-for="(item, index) in items" :key="index">
      <strong>Item {{ index + 1 }}</strong>
      <div class="mb-2">
        <label :for="'itemType' + index" class="form-label">Type</label>
        <input
          type="text"
          class="form-control"
          :id="'itemType' + index"
          required
          v-model="item.type"
        />
      </div>
      <div>
        <label :for="'itemWeight' + index" class="form-label">Weight</label>
        <input
          type="text"
          class="form-control"
          :id="'itemWeight' + index"
          required
          v-model="item.weight"
        />
      </div>
      <hr />
    </div>
    <button type="button" class="btn btn-primary" @click="addItem()">
      Add item
    </button>
    <button type="button" class="btn btn-success" @click="saveItems()">
      Save items
    </button>
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
      basketId: null,
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
      items: [],
      alert: null,
    };
  },
  created() {
    this.basketId = this.$route.params.id;
  },
  mounted() {},
  methods: {
    addItem() {
      this.items.push({ type: "", weight: 0 });
    },
    saveItems() {
      if (this.basketId) {
        axios
          .post(`/api/baskets/${this.basketId}/items`, this.items)
          .then((response) => {
            this.alert = {
              type: "alert-success",
              message: "Items Saved",
            };
            this.alert = null;
            this.$router.push({ name: "edit", params: { id: this.basketId } });
          })
          .catch((error) => {
            this.alert = {
              type: "alert-danger",
              message: error.response.data,
            };
            setTimeout(() => (this.alert = null), 3000);
          });
      }
    },
  },
};
</script>

<style>
</style>