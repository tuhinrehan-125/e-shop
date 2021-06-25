<template>
  <v-row>
    <v-col>
      <v-card class="mb-70">
        <v-card-title>
          <h2 class="overline variation-title">Add Purchase</h2>
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
                  label="Select supplier"
                  v-model="form.supplier_id"
                  :items="suppliers"
                  item-text="name"
                  item-value="id"
                  dense
                  :rules="[v => !!v || 'Supplier is required']"
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
                  :return-value.sync="form.purchase_date"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="form.purchase_date"
                      label="Purchase date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      dense
                      :rules="[v => !!v || 'Date is required']"
                      outlined
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="form.purchase_date" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="modal = false">
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.dialog.save(form.purchase_date)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Status"
                  v-model="form.purchase_status"
                  :items="purchase_statuses"
                  dense
                  :rules="[v => !!v || 'Status is required']"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-file-input
                  label="Purchse document"
                  v-model="form.image"
                ></v-file-input>
              </v-col>
            </v-row>
            <h2 class="overline variation-title mb-2 text-center">
              Search Items
            </h2>
            <v-row no-gutters>
              <v-col>
                <search-product type="purchase" />
              </v-col>
            </v-row>
            <h2 class="overline variation-title mb-2 text-center">
              Purchase Items
            </h2>
            <purchase-table />
            <v-row no-gutters>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Tax"
                  outlined
                  dense
                  required
                  v-model="form.purchase_tax"
                  @keyup="addTax($event.target.value)"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Discount"
                  outlined
                  dense
                  required
                  v-model="form.purchase_discount"
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
            <div v-if="isEdit == false">
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
import purchaseTable from "@/components/purchase/purchaseTable";
export default {
  props: ["suppliers", "data"],
  name: "addorupdatepurchase",
  components: { searchProduct, purchaseTable },
  data() {
    return {
      isEdit: false,
      valid: false,
      isLoading: false,
      purchase_statuses: ["Received", "Pending", "Ordered", "Draft", "Final"],
      modal: false,
      form: {
        business_location_id: "",
        supplier_id: "",
        purchase_status: "",
        purchase_date: new Date().toISOString().substr(0, 10),
        purchase_tax: "",
        purchase_discount: "",
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
      let grandtotal = this.$store.getters["product/totalPrice"];
      return Math.round(grandtotal);
    },
    purchaseItems() {
      let products = this.$store.getters["product/getcartItems"];
      return products;
    }
  },
  mounted() {
    if (Object.keys(this.data).length > 1) {
      this.isEdit = true;
       this.$refs.form.reset()
      this.form = this.data;
      this.$store.commit("product/SET_PURCHASE_PRODUCTS", this.data.items);
    }
  },
  methods: {
    addTax(val) {
      this.$store.dispatch("product/updateCartItem", {
        tax: val,
        type: "totaltax"
      });
    },
    addDiscount(val) {
      this.$store.dispatch("product/updateCartItem", {
        discount: val,
        type: "totaldiscount"
      });
    },
    addShippingCost(val) {
      this.$store.dispatch("product/updateCartItem", {
        shipping_cost: val,
        type: "shippingcost"
      });
    },

    async submitForm() {
      if (this.$refs.form.validate()) {
        if (this.purchaseItems.length < 1) {
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
        this.isLoading = false;

        let formData = new FormData();
        for (var key in this.form) {
          formData.append(key, this.form[key]);
        }
        formData.append("purchase_items", JSON.stringify(this.purchaseItems));
        if (this.isEdit) {
          formData.append("_method", "PATCH");
          await this.$axios
            .post(`/purchase/${this.data.id}`, formData, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(response => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Purchase Updated Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "purchase-list" });
            });
        } else {
          await this.$axios
            .post("/purchase", formData, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(response => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Purchase Addedd Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "purchase-list" });
            });
        }
      }
    }
  }
};
</script>

<style scoped></style>
