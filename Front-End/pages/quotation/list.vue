<template>
  <v-container grid-list-sm>
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
        <v-card class="mb-70">
          <v-card-title>
            {{ $t("Quotation_list") }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6" xl="4">
                <!-- <v-btn
                  depressed
                  tile
                  color="primary"
                  @click="opendialog('add')"
                >
                  <v-icon left> mdi-plus </v-icon>
                  {{ $t("add_brand") }}
                </v-btn>
                <v-btn depressed tile color="warning">
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
                :items="quotationList"
                show-select
              >
                <template v-slot:item.actions="{ item }">
                  <nuxt-link :to="{
                        name: 'quotation-edit-id',
                        params: { id: item.id }
                      }">
                  <v-icon>
                    mdi-square-edit-outline
                  </v-icon>
                  </nuxt-link>
                  <v-icon @click="deleteQuotation(item)">
                    mdi-trash-can-outline
                  </v-icon>
                </template>
              </v-data-table>
              <v-pagination
              v-model="pagination.current"
              :length="pagination.total"
              @input="onPageChange"
            ></v-pagination>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "quotationListPage",
  head: {
    title: "Quotation List"
  },
  data() {
    return {
      pagination: {
        current: 1,
        total: 0
      },
      search: "",
      confirmation: false,
      quotationList: [],
      isLoading: false,
      quotation_id:null,
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("Date"),
          value: "quotation_date"
        },
        {
          sortable: false,
          text: this.$t("location"),
          value: "business_location"
        },
        {
          sortable: false,
          text: this.$t("Supplier"),
          value: "supplier"
        },
        {
          sortable: false,
          text: this.$t("Customer"),
          value: "customer"
        },
        {
          sortable: false,
          text: this.$t("Stutas"),
          value: "status"
        },
        {
          sortable: false,
          text: this.$t("Total"),
          value: "total_cost"
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions"
        }
      ];
    }
  },
  mounted() {
    this.getQuotationList();
  },
  methods: {
    searchItem(){

    },
    async getQuotationList() {
      this.isLoading = true;
      await this.$axios
        .get("/quotation?page=" + this.pagination.current)
        .then(response => {
          this.isLoading = false;
          this.quotationList = response.data.data;
          this.pagination.current = response.data.meta.current_page;
          this.pagination.total = response.data.meta.last_page;
        });
    },
    async confirmDelete() {
      await this.$axios.delete(`quotation/${this.quotation_id}`).then(res => {
        let data = {
          alert: true,
          message: "Quotation Deleted Successfully",
          type: "success"
        };
        this.$store.commit("SET_ALERT", data);
        this.confirmation = false;
        this.getQuotationList();
      });
    },
    onPageChange() {
      this.getQuotationList();
    },
    deleteQuotation(item) {
      this.confirmation = true;
      this.quotation_id = item.id;
    }
  }
};
</script>

<style scoped></style>
