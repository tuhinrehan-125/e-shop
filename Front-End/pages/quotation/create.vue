<template>
  <v-container>
    <add-or-update :supplier="supplier"  :customers="customers"/>
  </v-container>
</template>
<script>
import AddOrUpdate from "../../components/quotation/addOrUpdate.vue";
export default {
  name: "CreateQuotation",
  components: { AddOrUpdate },
  data() {
    return {
      supplier:[],
      units:[],
      customers:[],
    };
  },
  computed: {},
  mounted() {
    this.getSuppliers();
    this.getCustomers();
    this.$store.commit("product/INIT_CART_ITEMS");
  },
  methods: {
    async getSuppliers() {
      await this.$axios.get("/contact?type=supplier").then(response => {
        this.supplier = response.data;
      });
    },
    async getUnits() {
      await this.$axios.get("all-units").then(response => {
        this.units = response.data;
      });
    },
    async getCustomers() {
      await this.$axios.get("/contact?type=customer").then(response => {
        this.customers = response.data;
      });
    }
  }
};
</script>

<style scoped></style>
