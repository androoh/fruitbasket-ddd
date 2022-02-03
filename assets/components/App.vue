<template>
  <div>
    <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"> Fruit Basket App </a>
      </div>
    </nav>
    <div class="container pt-4 pb-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Table from "./Home";

export default {
  components: { Table },
  data() {
    return {
      message: "A list of words",
      words: [],
    };
  },
  mounted() {},
};
</script>

<style>
</style>