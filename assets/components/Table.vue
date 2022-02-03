<template>
  <div>
    <table class="table">
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.prop">
            {{ column.title }}
          </th>
          <th class="text-end" v-if="showActions">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td v-for="column in columns">
            {{ item[column.prop] }}
          </td>
          <td class="text-end" v-if="showActions">
            <div class="btn-group">
              <button
                type="button"
                class="btn-primary btn btn-sm"
                @click="$router.push({ name: 'edit', params: { id: item.id } })"
              >
                Edit
              </button>
              <button
                type="button"
                class="btn-danger btn btn-sm"
                @click="removeBasket(item.id)"
              >
                Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    items: Array,
    columns: Array,
    showActions: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {
    removeBasket(id) {
      this.$emit("delete-event", id);
    },
  },
};
</script>

<style>
</style>