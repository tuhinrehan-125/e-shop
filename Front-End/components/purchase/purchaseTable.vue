<template>
  <v-row class="mb-10">
    <v-col cols="12">
      <v-data-table
        :headers="headers"
        :items="purchaseItems"
        class="elevation-1"
        fixed-header
        :hide-default-footer="true"
      >
        <template v-slot:[`item.quantity`]="{ item }">
          <v-text-field
            dense
            outlined
            class="shrink"
            type="number"
            :value="item.quantity"
            @keyup="qtyChange($event.target.value, purchaseItems.indexOf(item))"
          ></v-text-field>
        </template>
        <template v-slot:item.unit="{ item }" v-slot:item.allunit="{item}">
          <v-select
            :value="item.unit"
            :items="item.allunit"
            item-text="name"
            item-value="id"
            dense
            outlined
            class="shrink"
            @change="unitChange($event, purchaseItems.indexOf(item))"
          ></v-select>
        </template>
        <template v-slot:[`item.purchase_price`]="{ item }">
          <v-text-field
            dense
            outlined
            class="shrink"
            type="number"
            :value="item.purchase_price"
            @keyup="
              priceChange($event.target.value, purchaseItems.indexOf(item))
            "
          ></v-text-field>
        </template>
        <template v-slot:[`item.discount`]="{ item }">
          <v-text-field
            dense
            outlined
            class="shrink"
            type="number"
            :value="item.discount"
            @keyup="
              discountChange($event.target.value, purchaseItems.indexOf(item))
            "
          ></v-text-field>
        </template>
        <template v-slot:[`item.tax`]="{ item }">
          <v-text-field
            dense
            outlined
            class="shrink"
            type="number"
            :value="item.tax"
            @keyup="taxChange($event.target.value, purchaseItems.indexOf(item))"
          ></v-text-field>
        </template>
        <template v-slot:[`item.action`]="{ item }">
          <v-icon small @click="removeItem(item, purchaseItems.indexOf(item))">
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: "purchaseTbale",
  data() {
    return {
      headers: [
        { text: "Name", value: "product" },
        { text: "Quantity", value: "quantity" },
        { text: "Unit", value: "unit" },
        { text: "Net Unit Cost", value: "purchase_price" },
        { text: "Discount", value: "discount" },
        { text: "Tax", value: "tax" },
        { text: "Subtotal", value: "subtotal" },
        { text: "Action", value: "action" }
      ]
    };
  },
  computed: {
    purchaseItems() {
      let products = this.$store.getters["product/getcartItems"];
      return products;
    }
  },
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {
    qtyChange(val, index) {
      this.$store.dispatch("product/updateCartItem", {
        quantity: val,
        index: index,
        type: "qtychange"
      });
    },
    priceChange(val, index) {
      this.$store.dispatch("product/updateCartItem", {
        purchase_price: parseInt(val),
        index: index,
        type: "pricechange"
      });
    },
    unitChange(val, index) {
      this.$store.dispatch("product/updateCartItem", {
        unitid: val,
        index: index,
        type: "unitchange"
      });
    },
    discountChange(val, index) {
      this.$store.dispatch("product/updateCartItem", {
        discount: parseInt(val),
        index: index,
        type: "discountchange"
      });
    },
    taxChange(val, index) {
      this.$store.dispatch("product/updateCartItem", {
        tax: parseInt(val),
        index: index,
        type: "taxchange"
      });
    },
    removeItem(val,index){
      this.$store.commit("product/REMOVE_PRODUCT", {
        id: val.id,
        index: index,
      });
    }
  }
};
</script>

<style scoped>
.v-text-field {
  width: 100px;
  margin-top: 10px !important;
}
</style>
