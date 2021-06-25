<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>
          <h2 class="overline variation-title">Add stock transfer</h2>
        </v-card-title>
        <v-card-text>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row>
              <v-col cols="12" sm="6" md="3">
                <v-select
                  label="Location from"
                  v-model="form.from_location"
                  :items="user_business_location"
                  item-text="name"
                  item-value="id"
                  dense
                  :disabled="isEdit"
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="3">
                <v-select
                  label="Location To"
                  v-model="form.to_location"
                  :items="user_business_location"
                  item-text="name"
                  item-value="id"
                  dense
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="3">
                <v-select
                  label="Status"
                  v-model="form.status"
                  :items="statuses"
                  dense
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="3">
                <v-text-field
                  label="Ref no"
                  v-model="form.ref_no"
                  dense
                  outlined
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center" no-gutters>
              <v-col cols="12" sm="8" md="8"> </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col cols="12">
      <v-card class="mb-70">
        <v-card-title>
          <h2 class="overline variation-title">Search Items</h2>
        </v-card-title>
        <v-card-text>
          <v-row no-gutters>
            <v-col cols="12">
              <search-product
                type="transfer"
                :location_id="form.from_location"
              />
            </v-col>
            <v-col cols="12">
              <transfer-table :units="units" />
            </v-col>
          </v-row>
          <v-row no-gutters>
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
            <v-col cols="12" md="4" sm="12" xl="4">
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
                Submit
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
import searchProduct from "@/components/product/searchProduct";
import transferTable from "@/components/stock/transferTable";
export default {
  props: ["data"],
  components: { searchProduct, transferTable },
  name: "addorupdateStockTransfer",
  data() {
    return {
      isEdit: false,
      isLoading: false,
      units: [],
      full_loading: false,
      valid: false,
      statuses: ["Pending", "Complete"],
      items: ["Item 1", "Item 2", "Item 3", "Item 4"],
      checkbox: false,
      form: {
        transfer_date: new Date().toISOString().substr(0, 10),
        status: "",
        from_location: "",
        to_location: "",
        ref_no: ""
      },
      modal: false
    };
  },
  computed: {
    user_business_location() {
      return this.$auth.user.data.user_business_location;
    },
    grandTotal() {
      let grandtotal = this.$store.getters["product/transferTotalPrice"];
      return Math.round(grandtotal);
    },
    transferItems() {
      return this.$store.getters["product/getTransferItems"];
    }
  },
  mounted() {
    this.getUnits();
    if (Object.keys(this.data).length > 1) {
      this.isEdit = true;
      this.$refs.form.reset();
      this.form = this.data;
      this.$store.commit("product/SET_TRANSFER_PRODUCTS", this.data.items);
    }
  },
  methods: {
    addShippingCost(val) {
      this.$store.dispatch("product/updateTransferItem", {
        shipping_cost: val,
        type: "shippingcost"
      });
    },
    async getUnits() {
      await this.$axios.get("/unit").then(response => {
        this.units = response.data;
      });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        this.isLoading = true;
        if (this.isEdit) {
          this.form.transfer_items = this.transferItems;
          await this.$axios
            .patch(`/stock-transfer/${this.data.id}`, this.form)
            .then(response => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Stok transfer Updated Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "stockTransfer-list" });
            });
        } else {
          await this.$axios
            .post("/stock-transfer", {
              transfer_items: this.transferItems,
              from_location: this.form.from_location,
              to_location: this.form.to_location,
              ref_no: this.form.ref_no,
              status: this.form.status,
              shipping_cost: this.form.shipping_cost,
              note: this.form.note,
              total: this.grandTotal
            })
            .then(res => {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Stock Transferred Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.isLoading = false;
              this.$router.push({ name: "stockTransfer-list" });
            });
        }
      }
    }
  },
  watch: {
    "form.from_location": function(val) {
      if (val == this.form.to_location) {
        this.form.from_location = null;
        this.form.to_location = null;
        let data = {
          alert: true,
          message: "same location trasnfer is not possible",
          type: "error"
        };
        this.$store.commit("SET_ALERT", data);
      }
    },
    "form.to_location": function(val) {
      if (val == this.form.from_location) {
        this.form.from_location = null;
        this.form.to_location = null;
        let data = {
          alert: true,
          message: "same location trasnfer is not possible",
          type: "error"
        };
        this.$store.commit("SET_ALERT", data);
      }
    }
  }
};
</script>

<style scoped></style>
