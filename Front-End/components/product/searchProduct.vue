<template>
  <v-autocomplete
    v-model="item"
    :loading="loading"
    :items="products"
    :search-input.sync="getProducts"
    ref="pro"
    clearable
    hide-no-data
    hide-selected
    item-text="product"
    item-value="variation_id"
    placeholder="Search Product by Name/SKU"
    solo-inverted
    filled
    return-object
  ></v-autocomplete>
</template>

<script>
export default {
  name: "searchProduct",
  props: ["type","location_id"],
  components: {},
  data() {
    return {
      item: "",
      loading: false,
      products: [],
      getProducts: null
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {},
  watch: {

    item(val) {
      if (this.type == "sell") {
        this.$store.dispatch("product/addItemToSell", {
          product: val.product,
          product_id: val.product_id,
          variation_id: val.variation_id,
          sell_quantity: 1,
          unit_price: val.sell_price,
          unit: val.unit,
          allunit: val.allunit,
          discount: 0,
          tax: val.tax
        });
      } else if (this.type == "purchase" || this.type == "quotation" ) {
        this.$store.dispatch("product/addItemToPurchase", {
          product: val.product,
          product_id: val.product_id,
          variation_id: val.variation_id,
          quantity: 1,
          unit_price: val.purchase_price,
          unit: val.unit,
          allunit: val.allunit,
          discount: 0,
          tax: val.tax
        });
      }
      else if (this.type == "transfer") {
        this.$store.dispatch("product/addItemToTransfer", {
          product: val.product,
          product_id: val.product_id,
          qty_available: val.qty_available,
          variation_id: val.variation_id,
          quantity: 1,
          unit: val.unit,
          purchase_price: val.purchase_price,
        });
      }
    },
    getProducts(val) {
      if (val) {
        if(this.type=='transfer' || this.type=='sell'){
          if(this.location_id=='' || this.location_id==null){
            alert('Select location from')
            return;
          }
        }
        this.loading = true;
        this.$axios
          .post("/product/search", { name: val, location_id:this.location_id })
          .then(response => {
            this.products = [];
            this.loading = false;
            this.products = response.data;
          })
          .catch(err => {
            this.loading = false;
          });
      }
    }
  }
};
</script>

<style scoped></style>
