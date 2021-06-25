<template>
  <v-container fluid grid-list-xl class="mt-5">
    <add-or-update
      :data="data"
      :supplier="supplier"
      :customers="customers"
    />
  </v-container>
</template>
<script>
import AddOrUpdate from "../../../components/quotation/addOrUpdate.vue";
export default {
  name: "EditQuatation",
  components: { AddOrUpdate },
  data() {
    return {};
  },
  computed: {},
  mounted() {

  },
  async asyncData({ params, $axios }) {
    const [data, supplier, customers] = await Promise.all([
      $axios.get(`quotation/${params.id}`),
      $axios.get("/contact?type=supplier"),
      $axios.get("/contact?type=customer"),
    ]);
    return {
      data: data.data.data,
      supplier: supplier.data,
      customers: customers.data,
    };
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
