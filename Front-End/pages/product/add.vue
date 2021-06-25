<template>
  <v-container>
    <add-product v-if="loaded" />
  </v-container>
</template>

<script>
import addProduct from "../../components/product/addProduct";

export default {
  name: "addProductPage",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("product.add")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Add Product"
  },
  components: { addProduct },
  data() {
    return {
      loaded: false
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {
    this.loaded = true;
  },
  methods: {}
};
</script>

<style lang="scss" scoped></style>
