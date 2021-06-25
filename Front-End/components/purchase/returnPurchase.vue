<template>
  <v-dialog v-model="dialog" persistent max-width="1200px">
    <v-card>
      <v-card-title>
        Purchase Return<v-spacer />
        <v-icon aria-label="Close" @click="closedialog"> mdi-close </v-icon>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="6" sm="6" md="6">
              <p class="font-weight-bold text-center">
                Purchase Details
              </p>
              <v-list>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Location</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.business_location }}
                  </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Purchase Date</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.purchase_date }}
                  </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Total Purchase items</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.total_purchase_quantity }}
                  </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Subtotal</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.subtotal_cost }}
                  </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Tax</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.purchase_tax }}
                  </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Shipping cost</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.shipping_charge }}
                  </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Discount</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.purchase_discount }}
                  </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>Total</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    {{ item.total_cost }}
                  </v-list-item-action>
                </v-list-item>
              </v-list>
            </v-col>
            <v-divider vertical></v-divider>
            <v-col cols="6" sm="6" md="6">
              <p class="font-weight-bold text-center">
                Purchase Items
              </p>
              <v-data-table
                v-model="selected"
                :headers="headers"
                :items="purchaseitems"
                item-key="id"
                show-select
                class="elevation-1"
              >
                <template v-slot:[`item.quantity`]="{ item }">
                  <v-text-field
                    dense
                    outlined
                    class="shrink"
                    type="number"
                    :value="item.quantity"
                     @keyup="qtyChange($event.target.value,item,purchaseitems.indexOf(item))"
                  ></v-text-field>
                </template>
              </v-data-table>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closedialog">
          {{ $t("close") }}
        </v-btn>
        <v-btn color="blue darken-1" text @click="submitForm">
          {{ $t("save") }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: ["item", "ItemList"],
  name: "returnPurchase",
  data() {
    return {
      singleSelect: false,
      selected: [],
      purchaseitems: this.ItemList
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
          text: this.$t("quantity"),
          value: "quantity"
        }
      ];
    },
    dialog() {
      return this.$store.getters.modaltype == "returnPurchase"
        ? this.$store.getters.modal
        : false;
    },
    modaltype() {
      return this.$store.getters.modaltype;
    }
  },
  mounted() {},
  methods: {
    closedialog() {
      this.$store.commit("SET_MODAL", { type: "", status: false });
    },
    qtyChange(val,item,index){
      let check=this.selected.includes(item)
      if(!check){
          this.selected.push(item)
      }
      let return_item=this.selected.find((selected) => {
        return item.id == selected.id;
      });
      return_item['quantity']=val
    },
    async submitForm() {
      await this.$axios
        .patch(`/purchase-return/${this.item.id}`,{
          purchase_return:this.selected
          })
        .then(res => {
          let data = {
            alert: true,
            message: "Purchase return successfully",
            type: "success"
          };
          this.selected=[]
          this.$store.commit("SET_ALERT", data);
          this.$store.commit("SET_MODAL", false);
          this.$emit("refresh");
        });
    }
  },
  watch: {
    ItemList(val) {
      this.purchaseitems = val;
    }
  }
};
</script>

<style scoped>
.v-list-item {
  min-height: 29px;
}
.v-list-item__content {
  padding: 5px 0;
}
.v-list-item__title {
  font-size: 0.85rem;
}
.v-list-item__action {
  font-size: 0.85rem;
}
.v-text-field {
  width: 100px;
  margin-top: 10px !important;
  height: 50px;
  padding: 0px;
}
</style>
