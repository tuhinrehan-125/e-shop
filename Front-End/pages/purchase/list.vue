<template>
  <v-container grid-list-sm>
    <v-overlay :value="full_loading">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <add-payment :item="singleitem" type="purchase" />
    <view-payment :data="paymentinfo" />
    <return-purchase :item="singleitem" :ItemList="purchaseItems" />
    <v-row justify="center">
      <v-dialog v-model="confirmation" max-width="300">
        <v-card>
          <v-card-title>
            Are you sure?
            <v-spacer />
            <v-icon aria-label="Close" @click="confirmation = false">
              mdi-close
            </v-icon>
          </v-card-title>
          <v-card-text class="pb-6 pt-12 text-center">
            <v-btn class="mr-3" text @click="confirmation = false"> No </v-btn>
            <v-btn color="success" text @click="confirmDelete()"> Yes </v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
    <v-row>
      <v-col>
        <v-card>
          <v-card-title>
            {{ $t("Purchase List") }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6" xl="4">
                <v-btn depressed tile color="primary" to="/sell/create">
                  <v-icon left> mdi-plus </v-icon>
                  {{ $t("Add Purchase") }}
                </v-btn>
                <v-btn depressed tile color="warning">
                  <v-icon left> mdi-file-document-outline </v-icon>
                  {{ $t("Import Purchase") }}
                </v-btn>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
                xl="8"
                class="table-export text-right"
              >
                <v-icon class="excel rounded" color="#20AB11">
                  mdi-file-document-outline
                </v-icon>
                <v-icon class="pdf rounded" color="#FF8800">
                  mdi-file-pdf-box
                </v-icon>
                <v-icon class="printer rounded" color="primary">
                  mdi-printer
                </v-icon>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6" md="2" sm="2" xl="2">
                <v-select label="Bulk Action" outlined dense></v-select>
              </v-col>
              <v-col cols="6" md="10" sm="10" xl="10">
                <v-row no-gutters class="filter-section d-flex justify-end">
                  <v-col cols="6" md="2" sm="2" xl="2">
                    <v-text-field
                      v-model="search.date"
                      label="Date"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="6" md="2" sm="6" xl="2">
                    <v-select label="Client" outlined dense></v-select>
                  </v-col>
                  <v-col cols="6" md="2" sm="6" xl="2">
                    <v-select label="Store" outlined dense></v-select>
                  </v-col>
                  <v-col cols="6" md="2" sm="6" xl="2">
                    <v-select label="Purchase Status" outlined dense></v-select>
                  </v-col>
                  <v-col cols="6" md="2" sm="6" xl="2">
                    <v-select label="Payment Status" outlined dense></v-select>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <div class="datatable">
              <v-skeleton-loader
                v-if="isLoading"
                type="table"
              ></v-skeleton-loader>
              <v-data-table
                v-else
                :headers="headers"
                :items="purchaselist"
                show-select
              >
                <template v-slot:item.image="{ item }">
                  <img
                    class="product-img"
                    :src="item.image"
                    style="width: 50px; height: 50px"
                  />
                </template>

                <template v-slot:item.actions="{ item }">
                  <v-menu open-on-hover bottom left offset-y>
                    <template v-slot:activator="{ on, attrs }">
                      <v-icon v-bind="attrs" v-on="on">
                        mdi-dots-vertical
                      </v-icon>
                    </template>
                    <v-list>
                      <v-list-item
                        link
                        @click="openAddPayment(item)"
                        v-if="item.total_due != 0"
                      >
                        <v-icon>mdi-plus</v-icon>
                        <v-list-item-title>Add Payment</v-list-item-title>
                      </v-list-item>
                      <v-list-item link @click="openViewPayment(item)">
                        <v-icon>mdi-eye</v-icon>
                        <v-list-item-title>View Payment</v-list-item-title>
                      </v-list-item>
                      <v-list-item link @click="openReturnPurchase(item)">
                        <v-icon>mdi-keyboard-return</v-icon>
                        <v-list-item-title>Return Purchase</v-list-item-title>
                      </v-list-item>
                      <v-list-item
                        link
                        :to="{
                          name: 'purchase-edit-id',
                          params: { id: item.id },
                        }"
                      >
                        <v-icon>mdi-square-edit-outline</v-icon>
                        <v-list-item-title> Edit</v-list-item-title>
                      </v-list-item>
                      <v-list-item link @click="deleteProduct(item)">
                        <v-icon>mdi-trash-can-outline</v-icon>
                        <v-list-item-title>Delete</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </template>
              </v-data-table>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import addPayment from "../../components/payment/addPayment";
import viewPayment from "../../components/payment/viewPayment";
import returnPurchase from "../../components/purchase/returnPurchase";
export default {
  name: "Purchase",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("purchase.view")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Purchase List",
  },
  components: { addPayment, viewPayment, returnPurchase },
  data() {
    return {
      full_loading: false,
      purchaseItems: [],
      singleitem: {},
      paymentinfo: [],
      search: {},
      isLoading: false,
      update: false,
      alert: false,
      dialog: false,
      confirmation: false,
      message: "",
      headline: this.$t("Add Purchase"),
      valid: true,
      nameRules: [(v) => !!v || this.$t("purchase_name_is_required")],
      form: {
        date: "",
        reference: "",
        supplier: "",
        purchase_status: "",
        grand_total: "",
        paid: "",
        due: "",
        payment_status: "",
      },
      prodid: "",
      categories: [],
      purchaselist: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("Date"),
          value: "purchase_date",
        },
        {
          sortable: false,
          text: this.$t("location"),
          value: "business_location",
        },
        {
          sortable: false,
          text: this.$t("Supplier"),
          value: "supplier",
        },
        {
          sortable: false,
          text: this.$t("Purchase Stutas"),
          value: "purchase_status",
        },
        {
          sortable: false,
          text: this.$t("Payment Status"),
          value: "payment_status",
        },
        {
          sortable: false,
          text: this.$t("Grand Total"),
          value: "total_cost",
        },
        {
          sortable: false,
          text: this.$t("Paid"),
          value: "total_paid",
        },
        {
          sortable: false,
          text: this.$t("Due"),
          value: "total_due",
        },

        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
        },
      ];
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getPurchaseList();
  },
  methods: {
    openAddPayment(item) {
      this.singleitem = item;
      this.$store.commit("SET_MODAL", { type: "addpayment", status: true });
    },
    async openViewPayment(item) {
      this.full_loading = true;
      await this.$axios.get("purchase-payment?id=" + item.id).then((res) => {
        this.paymentinfo = res.data.data;
        this.$store.commit("SET_MODAL", { type: "viewpayment", status: true });
        this.full_loading = false;
      });
    },
    async openReturnPurchase(item) {
      this.full_loading = true;
      await this.$axios
        .get("purchase-items?purchase_id=" + item.id)
        .then((res) => {
          this.purchaseItems = res.data;
          this.singleitem = item;
          this.$store.commit("SET_MODAL", {
            type: "returnPurchase",
            status: true,
          });
          this.full_loading = false;
        });
    },
    deleteProduct(item) {
      this.confirmation = true;
      this.prodid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`product/${this.prodid}`).then((res) => {
        this.alert = true;
        this.message = "Purchase Deleted Successfully";
        this.confirmation = false;
        this.getProducts();
      });
    },
    async getPurchaseList() {
      this.isLoading = true;
      await this.$axios.get("/purchase").then((response) => {
        this.isLoading = false;
        this.purchaselist = response.data;
      });
    },
  },
};
</script>

<style lang="scss" scoped></style>
