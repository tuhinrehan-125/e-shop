<template>
  <v-container>
    <add-or-update :customers="customers" />
  </v-container>
</template>

<script>
import AddOrUpdate from "../../components/sell/addOrUpdate";
export default {
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("sell.add")) {
      return redirect("/dashboard");
    }
  },
  name: "addsellpage",
  head: {
    title: "Add sell"
  },

  components: { AddOrUpdate },
  data() {
    return {
      customers:[],
    };
  },
  computed: {
    user_business_location() {
      return this.$auth.user.data.user_business_location;
    },
    grandTotal() {
      let grandtotal = this.$store.getters["product/sellTotalPrice"];
      return Math.round(grandtotal);
    },
    sellItems() {
      let products = this.$store.getters["product/getSellItems"];
      return products;
    }
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getCustomers();
    this.$store.commit("product/INIT_SELL_ITEMS");
  },
  watch: {},
  methods: {
    async getCustomers() {
      await this.$axios.get("/contact?type=customer").then(response => {
        this.customers = response.data;
      });
    },
  }
};
</script>

<style scoped></style>
