<template>
  <v-container fluid grid-list-xl class="mt-5">
    <add-or-update
      :data="data"
    />
  </v-container>
</template>
<script>
import AddOrUpdate from "../../../components/stockTransfer/addOrUpdate";
export default {
   name: "EditStockTransfer",
  components: { AddOrUpdate },
  data() {
    return {

    };
  },
  computed: {

  },
  async asyncData({ params, $axios }) {
    const [data] = await Promise.all([
      $axios.get(`stock-transfer/${params.id}`),
    ]);
    return {
      data: data.data.data
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
