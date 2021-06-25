<template>
  <v-container>
    <add-or-update :suppliers="suppliers" :units="units" />
  </v-container>
</template>

<script>
import AddOrUpdate from "../../components/purchase/addOrUpdate";
export default {
  name: "addPurchasePage",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("purchase.add")) {
      return redirect("/dashboard");
    }
  },
  components: { AddOrUpdate },
  head: {
    title: "Add Purchase"
  },
  data() {
    return {
      units: [],
      suppliers: []
    };
  },

  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {
    this.getSuppliers();
    this.getUnits();
    this.$store.commit("product/INIT_CART_ITEMS");
  },
  watch: {},

  methods: {
    async getUnits() {
      await this.$axios.get("all-units").then(response => {
        this.units = response.data;
      });
    },
    async getSuppliers() {
      await this.$axios.get("/contact?type=supplier").then(response => {
        this.suppliers = response.data;
      });
    }
  }
};
</script>

<style scoped></style>
