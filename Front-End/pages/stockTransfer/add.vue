<template>
  <v-container>
    <add-or-update />
  </v-container>
</template>

<script>
import AddOrUpdate from "../../components/stockTransfer/addOrUpdate";
export default {
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("stock_transfer.add")) {
      return redirect("/dashboard");
    }
  },
  name: "stockTransferAdd",
  head: {
    title: "Add stock Transfer "
  },
  components: { AddOrUpdate },
  data() {
    return {
      units: [],
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {
  },
  methods: {
  }
};
</script>

<style></style>
