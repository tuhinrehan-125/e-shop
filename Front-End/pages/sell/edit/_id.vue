<template>
  <v-container fluid grid-list-xl class="mt-5">
    <add-or-update
      :data="data"
      :customers="customers"
    />
  </v-container>
</template>
<script>
import AddOrUpdate from "../../../components/sell/addOrUpdate";
export default {
   name: "EditSell",
  components: { AddOrUpdate },
  data() {
    return {

    };
  },
  computed: {

  },
  async asyncData({ params, $axios }) {
    const [data, customers, units] = await Promise.all([
      $axios.get(`sell/${params.id}`),
      $axios.get("/contact?type=customer"),
    ]);
    return {
      data: data.data.data,
      customers: customers.data,
    };
  },
  mounted() {
  },
  methods: {

  }
};
</script>

<style scoped>
</style>
