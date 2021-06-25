<template>
  <v-row class="mb-10">
    <v-col cols="12">
      <v-data-table
        :headers="headers"
        :items="sellItems"
        class="elevation-1"
        fixed-header
        :hide-default-footer="true"
      >
        <template v-slot:[`item.sell_quantity`]="{ item }">
          <v-text-field
            dense
            outlined
            class="shrink"
            type="number"
            :value="item.sell_quantity"
            @keyup="qtyChange($event.target.value, sellItems.indexOf(item))"
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
            @change="unitChange($event, sellItems.indexOf(item))"
          ></v-select>
        </template>
        <template v-slot:[`item.discount`]="{ item }">
          <v-text-field
            dense
            outlined
            class="shrink"
            type="number"
            :value="item.discount"
            @keyup="
              discountChange($event.target.value, sellItems.indexOf(item))
            "
          ></v-text-field>
        </template>
        <template v-slot:[`item.action`]="{ item }">
          <v-icon small @click="removeItem(item, sellItems.indexOf(item))">
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: "sellTable",
  data() {
    return {
      headers: [
        { text: "Name", value: "product" },
        { text: "Quantity", value: "sell_quantity" },
        { text: "Unit", value: "unit" },
        { text: "Unit Price", value: "unit_price" },
        { text: "Discount", value: "discount" },
        { text: "Subtotal", value: "subtotal" },
        { text: "Action", value: "action" }
      ]
    };
  },
  computed: {
    sellItems() {
      let products = this.$store.getters["product/getSellItems"];
      return products;
    }
  },
  async asyncData({ params, axios }) {},
  methods: {
    qtyChange(val, index) {
      this.$store.dispatch("product/updateSellItem", {
        sell_quantity: val,
        index: index,
        type: "qtychange"
      });
    },
    priceChange(val, index) {
      this.$store.dispatch("product/updateSellItem", {
        purchase_price: parseInt(val),
        index: index,
        type: "pricechange"
      });
    },
    discountChange(val, index) {
      this.$store.dispatch("product/updateSellItem", {
        discount: parseInt(val),
        index: index,
        type: "discountchange"
      });
    },
    unitChange(val, index) {
      this.$store.dispatch("product/updateSellItem", {
        unitid: val,
        index: index,
        type: "unitchange"
      });
    },
    removeItem(val,index){
      this.$store.commit("product/REMOVE_SELL_PRODUCT", {
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
