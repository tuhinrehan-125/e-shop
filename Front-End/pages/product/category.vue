<template>
  <v-container grid-list-sm>
    <v-row justify="center">
      <add-category :items="items" @refresh="getCategories()" v-if="add" />
      <edit-category
        :item="singleItem"
        :items="items"
        @refresh="getCategories()"
        v-if="edit"
      />
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
        <v-card  class="mb-70">
          <v-card-title>
            {{ $t("category_list") }}
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
                  {{ $t("add_category") }}
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
                :items="items"
                show-select
              >
                <template v-slot:item.actions="{ item }">
                  <v-icon @click="editCategory(item)">
                    mdi-square-edit-outline
                  </v-icon>
                  <v-icon @click="deleteCategory(item)">
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
import addCategory from "../../components/product/addCategory.vue";
import editCategory from "../../components/product/editCategory.vue";
export default {
  name: "Category",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("category.view")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Category"
  },
  components: { addCategory, editCategory },
  data() {
    return {
      add:false,
      edit:false,
      search: "",
      isLoading: false,
      confirmation: false,
      update: false,
      headline: this.$t("category_add"),
      dialog: false,
      catid: "",
      categories: [],
      items: [],
      singleItem: {}
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("name"),
          value: "name"
        },
        {
          sortable: false,
          text: this.$t("parent_category"),
          value: "parent_cat_name"
        },
        {
          sortable: false,
          text: this.$t("short_code"),
          value: "short_code"
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
    this.getCategories();
  },
  methods: {
    searchItem(){

    },
    opendialog(type) {
      this.add=true
      this.$store.commit("SET_MODAL", { type: type, status: true });
    },
    async getCategories() {
      this.isLoading = true;
      await this.$axios.get("/category").then(response => {
        this.items = response.data;
        this.isLoading = false;
      });
    },
    deleteCategory(item) {
      this.confirmation = true;
      this.catid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`category/${this.catid}`).then(res => {
        let data = {
          alert: true,
          message: "Category Deleted Successfully",
          type: "success"
        };
        this.$store.commit("SET_ALERT", data);
        this.$store.commit("SET_MODAL", false);
        this.confirmation = false;
        this.getCategories();
      });
    },
    editCategory(item) {
      this.edit=true
      this.$store.commit("SET_MODAL", { type: "edit", status: true });
      this.singleItem = item;
    }
  }
};
</script>

<style></style>
