<template>
  <v-container fluid grid-list-xl>
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
      <v-col cols="12" md="12">
         <v-card  class="mb-70">
          <v-card-title>
            {{ $t("expense_list") }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6" xl="4">
                <v-btn
                  depressed
                  tile
                  color="primary"
                  to="/expense/add"
                >
                  <v-icon left> mdi-plus </v-icon>
                  {{ $t("add_expense") }}
                </v-btn>
                <!-- <v-btn depressed tile color="warning">
                  <v-icon left> mdi-file-document-outline </v-icon>
                  {{ $t("Import Supplier") }}
                </v-btn> -->
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
                      label="Search"
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
                :items="expenses"
                show-select
              >
               <template v-slot:item.is_monthly_expense="{ item }">
                <v-chip class="ma-2" color="success" v-if="item.is_monthly_expense=='1'">Yes</v-chip>
                <v-chip class="ma-2" v-else>No</v-chip>
              </template>
                <template v-slot:item.actions="{ item }">
                  <v-icon @click="editExpense(item)">
                    mdi-square-edit-outline
                  </v-icon>
                  <v-icon @click="deleteExpense(item)">
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
export default {
  name: "ExpenseList",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("expense.view")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Expense List"
  },
  data() {
    return {
      search: "",
      confirmation: false,
      isLoading: false,
      dateMenu: false,
      dateValue: null,
      dialog: false,
      expid: "",
      expenseCats: [],
      form: {},
      headers: [
        {
          sortable: false,
          text: this.$t("Is Monthly"),
          value: "is_monthly_expense"
        },
        {
          sortable: false,
          text: this.$t("amount"),
          value: "amount"
        },
        {
          sortable: false,
          text: this.$t("expense_date"),
          value: "exp_date"
        },
        {
          sortable: false,
          text: this.$t("expense_category"),
          value: "exp_cat_name"
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions"
        }
      ],
      expenses: []
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {
    this.getExpCategories();
    this.getExpense();
  },
  methods: {
    opendialog(type) {
      this.$store.commit("SET_MODAL", { type: type, status: true });
    },
  searchItem(){

  },
    async getExpCategories() {
      await this.$axios.get("/expense-category").then(response => {
        this.expenseCats = response.data;
      });
    },
    async getExpense() {
      this.isLoading = true;
      await this.$axios.get("/expense").then(response => {
        this.isLoading = false;
        this.expenses = response.data;
      });
    },
    deleteExpense(item) {
      this.confirmation = true;
      this.expid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`expense/${this.expid}`).then(res => {
        this.alert = true;
        this.message = "Expense Deleted Successfully";
        this.confirmation = false;
        this.getExpense();
      });
    }
  }
};
</script>

<style></style>
