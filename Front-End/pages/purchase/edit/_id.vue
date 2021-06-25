<template>
  <v-container fluid grid-list-xl class="mt-5">
    <add-or-update :data="data" :suppliers="suppliers" />
  </v-container>
</template>
<script>
import AddOrUpdate from "../../../components/purchase/addOrUpdate";
export default {
  name: "editpurchase",
  components: { AddOrUpdate },
  data() {
    return {};
  },
  computed: {},
  async asyncData({ params, $axios }) {
    const [data, suppliers] = await Promise.all([
      $axios.get(`purchase/${params.id}`),
      $axios.get("/contact?type=supplier"),
    ]);
    return {
      data: data.data.data,
      suppliers: suppliers.data,
    };
  },
  mounted() {},
  methods: {}
};
</script>

<style scoped></style>
