<template>
  <v-container fluid grid-list-sm>
    <v-row justify="center">
      <add-unit  :items="items" @refresh="getUnits()" v-if="add" />
      <edit-unit :item="singleItem" :items="items" @refresh="getUnits()"  v-if="edit"/>
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
            {{ $t("Unit List") }}
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
                  {{ $t("Add Unit") }}
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
                  <v-icon @click="editUnit(item)">
                    mdi-square-edit-outline
                  </v-icon>
                  <v-icon @click="deleteUnit(item)">
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
import addUnit from "~/components/product/addUnit";
import editUnit from "~/components/product/editUnit";
export default {
  name: "AddUnit",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("unit.view")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Add Unit",
  },
  components: {addUnit,editUnit},
  data() {
    return {
      add:false,
      edit:false,
      search: "",
      isLoading: false,
      confirmation: false,
      update: false,
      headline: this.$t("Unit Add"),
      nameRules: [(v) => !!v || this.$t("Unit name is required")],
      dialog: false,
      units: [],
      unitId: "",
      categories: [],
      items: [],
      singleItem:{},
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("name"),
          value: "name",
        },
        {
          sortable: false,
          text: this.$t("Short Name"),
          value: "short_name",
        },

        {
          sortable: false,
          text: this.$t("Base Unit"),
          value: "parent_cat_name",
        },

        {
          sortable: false,
          text: this.$t("Operation Value"),
          value: "value",
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
    this.getUnits();
  },
  methods: {
    opendialog(type) {
      this.add=true
      this.$store.commit("SET_MODAL", {type:type,status:true});
    },
    searchItem(){

    },
    async getUnits() {
      this.isLoading = true;
      await this.$axios.get("/unit").then((response) => {
        this.items = response.data;
        this.isLoading = false;
      });
    },
    deleteUnit(item) {
      this.confirmation = true;
      this.unitId = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`unit/${this.unitId}`).then((res) => {
        this.alert = true;
        this.message = "Unit Deleted Successfully";
        this.confirmation = false;
        this.getUnits();
      });
    },

    editUnit(item) {
      this.edit=true
      this.$store.commit("SET_MODAL", {type:'edit',status:true});
      this.singleItem=item
    },

  },
};
</script>

