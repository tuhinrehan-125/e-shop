<template>
  <v-container fluid grid-list-xl class="mt-5">
    <v-row>
      <v-col cols="12" md="12">
        <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("Purchase Return List") }}
            <v-spacer></v-spacer>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers" :items="returnList">
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("purchase_return.view")) {
      return redirect("/dashboard");
    }
  },
  name: "PurchaseReturnPage",
  data() {
    return {
      isLoading:false,
      returnList:[],
    };
  },
  computed: {
     headers() {
      return [
        {
          sortable: false,
          text: this.$t("product"),
          value: "product_variation"
        },
        {
          sortable: false,
          text: this.$t("return_quantity"),
          value: "return_quantity"
        },
         {
          sortable: false,
          text: this.$t("total_amount"),
          value: "total_amount"
        },
      ]
     }
  },
  created() {
    this.isLoading=true
      this.$axios.get('/purchase-return-list')
      .then(res=>{
        this.isLoading=false
        this.returnList=res.data
      })
  },
  methods: {

  }
};
</script>

<style scoped></style>
