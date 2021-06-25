<template>
  <v-container>
    <add-expense v-if="loaded"/>
  </v-container>
</template>

<script>
import addExpense from "../../components/expense/addExpense";

export default {
  name: "addProductPage",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("expense.add")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Add Expense",
  },
  components: { addExpense },
  data() {
    return {
      loaded:false,
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {
    this.loaded=true
  },
  methods: {},
};
</script>

<style lang="scss" scoped>
</style>
