<template>
  <v-row class="mb-10">
    <v-col cols="12">
      <v-data-table
        :headers="headers"
        :items="transferItems"
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
            @keyup="
              qtyChange($event.target.value, item, transferItems.indexOf(item))
            "
          ></v-text-field>
        </template>
        <template v-slot:[`item.unit`]="{ item }">
          <v-select
            :value="item.unit"
            :items="units"
            item-text="name"
            item-value="id"
            dense
            outlined
            class="shrink"
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
              priceChange($event.target.value, transferItems.indexOf(item))
            "
          ></v-text-field>
        </template>
        <template v-slot:[`item.action`]="{ item }">
          <v-icon small @click="removeItem(item, transferItems.indexOf(item))">
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: "stockTransferTable",
  props: ["units"],
  data() {
    return {
      headers: [
        { text: "Name", value: "product" },
        { text: "Quantity", value: "quantity" },
        { text: "Unit", value: "unit" },
        { text: "Unit Price", value: "purchase_price" },
        { text: "Subtotal", value: "subtotal" },
        { text: "Action", value: "action" }
      ]
    };
  },
  computed: {
    transferItems() {
      let products = this.$store.getters["product/getTransferItems"];
      return products;
    }
  },
  async asyncData({ params, axios }) {},
  methods: {
    qtyChange(val, item, index) {
      let transfered = item.already_transfered;
      let available = item.available;
      let reqQty = transfered > val ? transfered - val : val - transfered;
      if (available < reqQty) {
        alert("only " + available + " available");
        this.$store.dispatch("product/updateTransferItem", {
          quantity: item.already_transfered,
          index: index,
          type: "qtychange"
        });
      } else {
        this.$store.dispatch("product/updateTransferItem", {
          quantity: val,
          index: index,
          type: "qtychange"
        });
      }
    },
    priceChange(val, index) {
      this.$store.dispatch("product/updateTransferItem", {
        purchase_price: parseInt(val),
        index: index,
        type: "pricechange"
      });
    },
    removeItem(val, index) {
      this.$store.commit("product/REMOVE_SELL_PRODUCT", {
        id: val.id,
        index: index
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
