<template>
  <v-container grid-list-sm>
    <v-row justify="center">
      <add-customer @refresh="getcustomer()" v-if="add" />
      <edit-customer :item="singleItem" @refresh="getcustomer()" v-if="edit" />
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
            {{ $t("client_list") }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6" xl="4">
                <v-btn
                  depressed
                  tile
                  color="primary"
                  @click="opendialog('add')"
                >
                  <v-icon left> mdi-plus </v-icon>
                  {{ $t("add_customer") }}
                </v-btn>
                <v-btn depressed tile color="warning">
                  <v-icon left> mdi-file-document-outline </v-icon>
                  {{ $t("Import Customer") }}
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
                  <v-col cols="6" md="2" sm="6" xl="3">
                    <v-text-field
                      v-model="search"
                      @click:append="searchItem"
                      @keyup="searchItem"
                      label="Search by name or mobile number"
                      outlined
                      dense
                    ></v-text-field>
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
                :items="customer"
                show-select
              >
                <template v-slot:item.actions="{ item }">
                  <v-icon @click="editSupplier(item)">
                    mdi-square-edit-outline
                  </v-icon>
                  <v-icon @click="deleteSupplier(item)">
                    mdi-trash-can-outline
                  </v-icon>
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
import addCustomer from "../../components/contacts/addCustomer";
import editCustomer from "../../components/contacts/editCustomer";
export default {
  name: "customer",
  middleware: "auth",
  head() {
    return {
      title: "Customer",
    };
  },
  components: { addCustomer, editCustomer },
  data() {
    return {
      add: false,
      edit: false,
      search: "",
      isLoading: false,
      headline: this.$t("add_customer"),
      update: false,
      clienttid: "",
      confirmation: false,
      customer: [],
      singleItem: {},
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("customer_name"),
          value: "name",
        },
        {
          sortable: false,
          text: this.$t("mobile"),
          value: "mobile",
        },
        {
          sortable: false,
          text: this.$t("email"),
          value: "email",
        },
        {
          sortable: false,
          text: this.$t("address"),
          value: "address",
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
    this.getcustomer();
  },
  methods: {
    opendialog(type) {
      this.add = true;
      this.$store.commit("SET_MODAL", { type: type, status: true });
    },
    async searchItem() {
      await this.$axios
        .get("/contact?type=customer&keyword=" + this.search)
        .then((response) => {
          this.customer = response.data;
        });
    },
    async getcustomer() {
      this.isLoading = true;
      await this.$axios
        .get("/contact?type=customer")
        .then((response) => {
          this.$store.commit("SET_ALERT", { alert: false, message: "" });
          this.isLoading = false;
          this.customer = response.data;
        })
        .catch((err) => {
          console.log("error");
        });
    },
    deleteCustomer(item) {
      this.confirmation = true;
      this.customerid = item.id;
    },
    editcustomer(item) {
      this.edit = true;
      this.$store.commit("SET_MODAL", { type: "edit", status: true });
      this.singleItem = item;
    },
    async confirmDelete() {
      await this.$axios.delete(`contact/${this.customerid}`).then((res) => {
        let data = {
          alert: true,
          message: "customer Deleted Successfully",
          type: "success",
        };
        this.$store.commit("SET_ALERT", data);
        this.$store.commit("SET_MODAL", false);
        this.confirmation = false;
        this.getcustomer();
      });
    },
  },
  watch: {
    customer(val) {
      this.customer = val;
    },
  },
};
</script>

<style>
</style>
