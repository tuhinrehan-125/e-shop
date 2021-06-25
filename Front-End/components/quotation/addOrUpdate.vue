<template>
  <v-row>
    <v-col>
      <v-card class="mb-70">
        <v-card-title>
          <h2 class="overline variation-title">Add Quotation</h2>
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
                  label="Select business location"
                  v-model="form.business_location_id"
                  :items="user_business_location"
                  item-text="name"
                  item-value="id"
                  dense
                  :rules="reqRules"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Select supplier"
                  v-model="form.supplier_id"
                  :items="supplier"
                  item-text="name"
                  item-value="id"
                  dense
                  :rules="reqRules"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Select customer"
                  v-model="form.customer_id"
                  :items="customers"
                  item-text="name"
                  item-value="id"
                  dense
                  :rules="reqRules"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-dialog
                  ref="dialog"
                  v-model="modal"
                  :return-value.sync="form.quotation_date"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="form.quotation_date"
                      label="Quotation date"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      dense
                      :rules="[v => !!v || 'Date is required']"
                      outlined
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="form.quotation_date" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="modal = false">
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.dialog.save(form.quotation_date)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-select
                  label="Status"
                  v-model="form.status"
                  :items="statuses"
                  dense
                  :rules="reqRules"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-file-input
                  label="Document"
                  v-model="form.quotation_doc"
                ></v-file-input>
              </v-col>
            </v-row>
            <h2 class="overline variation-title mb-2 text-center">
              Search Items
            </h2>
            <v-row no-gutters>
              <v-col>
                <search-product type="quotation" />
              </v-col>
            </v-row>
            <h2 class="overline variation-title mb-2 text-center">
              Order Items
            </h2>
            <purchase-table />
            <v-row no-gutters>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Order Tax"
                  outlined
                  dense
                  required
                  v-model="form.tax"
                  @keyup="addTax($event.target.value)"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4" sm="12" xl="4">
                <v-text-field
                  label="Discount"
                  outlined
                  dense
                  required
                  v-model="form.discount"
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
import { VAlert } from "vuetify/lib";
export default {
  props: ["supplier", "customers", "data"],
  name: "addOrUpdateQuotation",
  components: { searchProduct, purchaseTable },
  data() {
    return {
      isEdit: false,
      isLoading: false,
      reqRules: [v => !!v || this.$t("this_field_is_required")],
      form: {
        quotation_date: new Date().toISOString().substr(0, 10)
      },
      modal: false,
      statuses: ["Pending", "Sent", "Completed"],
      valid: false
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
    quotationItems() {
      let products = this.$store.getters["product/getcartItems"];
      return products;
    }
  },
  mounted() {
    if (Object.keys(this.data).length > 1) {
      this.isEdit = true;
      this.$refs.form.reset();
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
        if (this.quotationItems.length < 1) {
          let data = {
            alert: true,
            message: "Please Select Product",
            type: "error"
          };
          this.$store.commit("SET_ALERT", data);
          return;
        }
        if (this.grandTotal < 1) {
          let data = {
            alert: true,
            message: "Total price can not be 0",
            type: "error"
          };
          this.$store.commit("SET_ALERT", data);
          return;
        }
        this.isLoading = true;
        let formData = new FormData();
        for (var key in this.form) {
          formData.append(key, this.form[key]);
        }
        formData.append("quotation_items", JSON.stringify(this.quotationItems));
        if (this.isEdit) {
          formData.append("_method", "PATCH");
          await this.$axios
            .post(`/quotation/${this.data.id}`, formData, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(response => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Quotation Updated Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "quotation-list" });
            });
        } else {
          await this.$axios
            .post("/quotation", formData, {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            })
            .then(response => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Quotation Saved Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "quotation-list" });
            });
        }
      }
    }
  },
  watch: {
    // 'form.quotation_date': {
    //   immediate: true,
    //   handler:function(val) {
    //     alert(val)
    //   this.form.quotation_date=val
    // },
    // }
  }
};
</script>

<style scoped></style>
