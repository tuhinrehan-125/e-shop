<template>
  <v-row>
    <v-col>
      <v-card class="mb-70">
        <v-card-title>
          <h2 class="overline variation-title">Add sell</h2>
        </v-card-title>
        <v-card-text>
          <v-form
            ref="form"
            method="post"
            v-model="valid"
            lazy-validation
            v-on:submit="submitForm"
          >
            <v-row no-gutters>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Select Customer"
                  v-model="form.customer_id"
                  :items="customers"
                  item-text="name"
                  item-value="id"
                  dense
                  :rules="[v => !!v || 'Customer is required']"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Select business location"
                  v-model="form.business_location_id"
                  :items="user_business_location"
                  item-text="name"
                  item-value="id"
                  dense
                  :rules="[v => !!v || 'Business location is required']"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-dialog
                  ref="dialog"
                  v-model="modal"
                  :return-value.sync="form.sell_date"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="form.sell_date"
                      label="sell date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      dense
                      :rules="[v => !!v || 'Date is required']"
                      outlined
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="form.sell_date" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="modal = false">
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.dialog.save(form.sell_date)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Status"
                  v-model="form.sell_status"
                  :items="sell_statuses"
                  dense
                  :rules="[v => !!v || 'Status is required']"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-file-input
                  label="sell document"
                  v-model="form.image"
                ></v-file-input>
              </v-col>
            </v-row>
            <h2 class="overline variation-title mb-2 text-center">
              Search Items
            </h2>
            <v-row no-gutters>
              <v-col>
                <search-product
                  type="sell"
                  :location_id="form.business_location_id"
                />
              </v-col>
            </v-row>
            <h2 class="overline variation-title mb-2 text-center">
              sell Items
            </h2>
            <sell-table />
            <v-row no-gutters>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Tax"
                  outlined
                  dense
                  required
                  v-model="form.sell_tax"
                  @keyup="addTax($event.target.value)"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Discount"
                  outlined
                  dense
                  required
                  v-model="form.sell_discount"
                  @keyup="addDiscount($event.target.value)"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Shipping cost"
                  outlined
                  dense
                  required
                  v-model="form.shipping_cost"
                  @keyup="addShippingCost($event.target.value)"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-textarea
                  rows="2"
                  label="Note"
                  outlined
                  dense
                  required
                  v-model="form.note"
                ></v-textarea>
              </v-col>
              <v-col cols="12">
                <h2 class="text-right">Total: {{ grandTotal }}</h2>
              </v-col>
            </v-row>
            <div v-if="isEdit==false">
            <h2 class="overline variation-title mb-2 text-center">
              Make Payment
            </h2>
            <v-row no-gutters>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Amount"
                  outlined
                  dense
                  required
                  v-model="form.payment_amount"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Select payment method"
                  v-model="form.payment_method"
                  :items="methods"
                  item-text="name"
                  item-value="id"
                  dense
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-textarea
                  rows="2"
                  label="Payment Note"
                  outlined
                  dense
                  required
                  v-model="form.payment_note"
                ></v-textarea>
              </v-col>
            </v-row>
            </div>
            <v-row>
              <v-col cols="12">
                <v-btn
                  class="float-right"
                  dark
                  color="success"
                  @click="submitForm"
                  :loading="isLoading"
                >
                  <v-icon dark> mdi-plus </v-icon>Submit
                </v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
import searchProduct from "@/components/product/searchProduct";
import sellTable from "@/components/sell/sellTable";
export default {
  props: ["customers", "data"],
  name: "addorupdatesell",
  components: { searchProduct, sellTable },
  data() {
    return {
      isEdit: false,
      isLoading: false,
      valid: false,
      sell_statuses: ["Final", "Pending"],
      modal: false,
      form: {
        business_location_id: "",
        customer_id: "",
        sell_status: "",
        sell_date: new Date().toISOString().substr(0, 10),
        sell_tax: "",
        sell_discount: "",
        shipping_cost: "",
        payment_amount: "",
        payment_method: "",
        payment_note: ""
      },
      methods: ["Cash", "Card", "Bank Transfer"]
    };
  },
  computed: {
    user_business_location() {
      return this.$auth.user.data.user_business_location;
    },
    grandTotal() {
      let grandtotal = this.$store.getters["product/sellTotalPrice"];
      return Math.round(grandtotal);
    },
    sellItems() {
      let products = this.$store.getters["product/getSellItems"];
      return products;
    }
  },
  mounted() {
    if (Object.keys(this.data).length > 1) {
      this.isEdit = true;
      this.$refs.form.reset()
      this.form = this.data;
      this.$store.commit("product/SET_SELL_PRODUCTS",this.data.items)
    }
  },

  methods: {
    addTax(val) {
      this.$store.dispatch("product/updateSellItem", {
        tax: val,
        type: "selltax"
      });
    },
    addDiscount(val) {
      this.$store.dispatch("product/updateSellItem", {
        discount: val,
        type: "selldiscount"
      });
    },
    addShippingCost(val) {
      this.$store.dispatch("product/updateSellItem", {
        shipping_cost: val,
        type: "shippingcost"
      });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        if (this.sellItems.length < 1) {
          this.type = "error";
          this.alert = true;
          this.message = { msg: ["Please Select Product"] };
          return;
        }
        if (this.grandTotal < 1) {
          this.type = "error";
          this.alert = true;
          this.message = { msg: ["Total price can not be 0"] };
          return;
        }
        this.isLoading = true;
        let formData = new FormData();
        for (var key in this.form) {
          formData.append(key, this.form[key]);
        }
       
        formData.append("sell_items", JSON.stringify(this.sellItems));
         if (this.isEdit) {
          formData.append("_method", "PATCH");
          await this.$axios
            .post(`/sell/${this.data.id}`, formData, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(response => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Sell Updated Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "sell-list" });
            });
        } else {
          await this.$axios
            .post("/sell", formData, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(response => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Sell Addedd Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "sell-list" });
            });
        }
      }
    }
  }
};
</script>

<style scoped></style>
