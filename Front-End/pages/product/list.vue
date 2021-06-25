<template>
  <v-container grid-list-sm>
    <div id="printable" ref="printable">
      <print-table :headers="headers" :data="productslist" />
    </div>
    <vue-html2pdf
      pdf-content-width="100%"
      :manual-pagination="true"
      :show-layout="true"
      :float-layout="false"
      pdf-orientation="landscape"
      ref="html2Pdf"
      id="printable"
      :html-to-pdf-options="htmlToPdfOptions"
    >
      <section slot="pdf-content">
        <print-table :headers="headers" :data="productslist" />
      </section>
    </vue-html2pdf>
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
            {{ $t("Product List") }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6" xl="4">
                <v-btn depressed tile color="primary" to="/sell/create">
                  <v-icon left> mdi-plus </v-icon>
                  {{ $t("Add Product") }}
                </v-btn>
                <v-btn depressed tile color="warning">
                  <v-icon left> mdi-file-document-outline </v-icon>
                  {{ $t("Import Product") }}
                </v-btn>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
                xl="8"
                class="table-export text-right"
              >
                <vue-json-to-csv :json-data="productslist">
                  <v-icon class="excel rounded" color="#20AB11">
                    mdi-file-document-outline
                  </v-icon>
                </vue-json-to-csv>
                <v-icon
                  class="pdf rounded"
                  color="#FF8800"
                  @click="generateReport"
                >
                  mdi-file-pdf-box
                </v-icon>
                <v-icon
                  class="printer rounded"
                  color="primary"
                  @click="printData"
                >
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
                  <v-col cols="6" md="2" sm="6" xl="2">
                    <v-text-field
                      outlined
                      dense
                      v-model="search.name"
                      placeholder="Search by name"
                      label="Search by name"
                      single-line
                      hide-details
                      @click:append="searchItem"
                      @keyup="searchItem"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="6" md="2" sm="6" xl="2">
                    <v-select
                      label="search by category"
                      placeholder="Search by category"
                      v-model="search.category_id"
                      :items="categories"
                      item-text="name"
                      item-value="id"
                      outlined
                      dense
                      @change="searchItem"
                    ></v-select>
                  </v-col>
                  <v-col cols="6" md="2" sm="6" xl="2">
                    <v-select
                      label="search by unit"
                      v-model="search.unit_id"
                      :items="units"
                      item-text="name"
                      item-value="id"
                      outlined
                      dense
                      @change="searchItem"
                    ></v-select>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <div class="datatable">
              <v-skeleton-loader
                v-if="isLoading"
                class="mx-auto"
                type="table"
              ></v-skeleton-loader>

              <v-data-table v-else :headers="headers" :items="productslist">
                <template v-slot:item.image="{ item }">
                  <img
                    class="product-img"
                    :src="item.image"
                    style="width: 60px; height: auto"
                  />
                </template>

                <template v-slot:item.actions="{ item }">
                  <nuxt-link
                    style="color: transparent"
                    :to="{
                      name: 'product-edit-id',
                      params: { id: item.id },
                    }"
                  >
                    <v-icon> mdi-square-edit-outline </v-icon>
                  </nuxt-link>
                  <v-icon @click="deleteProduct(item)">
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
import printTable from "../../components/utils/tablePrint.vue";
import VueJsonToCsv from "vue-json-to-csv";
export default {
  name: "ProductList",
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("product.view")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Product List",
  },
  components: { VueJsonToCsv, printTable },
  data() {
    return {
      search: {
        name: "",
        category_id: "",
        unit_id: "",
      },
      pagination: {
        current: 1,
        total: 0,
      },
      htmlToPdfOptions: {
        html2canvas: {
          dpi: 300,
          letterRendering: true,
          useCORS: true,
        },
      },
      isLoading: false,
      update: false,
      dialog: false,
      confirmation: false,
      headline: this.$t("add_product"),
      valid: true,
      catRules: [(v) => !!v || this.$t("category_is_required")],
      nameRules: [(v) => !!v || this.$t("product_name_is_required")],
      direction: "top right",
      form: {
        category_id: "",
        subcategory_id: "",
        name: "",
        details: "",
        unit_id: "",
        weight: "",
        price: "",
        image: null,
      },
      prodid: "",
      categories: [],
      productslist: [],
      categories: [],
      subcategories: [],
      units: [],
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("image"),
          value: "image",
        },
        {
          sortable: false,
          text: this.$t("product_name"),
          value: "name",
        },
        {
          sortable: false,
          text: this.$t("sku"),
          value: "sku",
        },
        {
          sortable: false,
          text: this.$t("category"),
          value: "category",
        },
        {
          sortable: false,
          text: this.$t("unit"),
          value: "unit_name",
        },
        {
          sortable: false,
          text: this.$t("Purchase Price"),
          value: "purchase_price",
        },
        {
          sortable: false,
          text: this.$t("Sell Price"),
          value: "sell_price",
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
        },
      ];
    },
    queryString() {
      return Object.keys(this.search)
        .map((k) => `${k}=${this.search[k]}`)
        .join("&");
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
    alert: {
      get: function () {
        return this.$store.getters.alert;
      },
      set: function (newValue) {},
    },
    message() {
      return this.$store.getters.message;
    },
  },
  async asyncData({ params, axios }) {},
  created() {
    this.getProducts();
    this.getCategories();
    this.getUnit();
  },
  methods: {
    generateReport() {
      this.$refs.html2Pdf.generatePdf();
    },
    editProduct(item) {
      this.update = true;
      this.dialog = true;
      this.headline = this.$t("edit_product");
      this.form.name = item.name;
      this.form.details = item.details;
      this.form.category_id = item.category_id;
      this.form.subcategory_id = item.subcategory_id;
      this.form.unit_id = item.unit_id;
      this.form.weight = item.weight;
      this.form.price = item.price;
      this.prodid = item.id;
    },
    async printData() {
      var mywindow = window.open("", "PRINT", "height=400,width=600");
      mywindow.document.write("</head><body >");
      mywindow.document.write(document.getElementById("printable").innerHTML);
      mywindow.document.write("</body></html>");
      mywindow.document.close();
      var is_chrome = Boolean(mywindow.chrome);
      if (is_chrome) {
        mywindow.onload = function () {
          // wait until all resources loaded
          mywindow.focus(); // necessary for IE >= 10
          mywindow.print(); // change window to mywindow
          mywindow.close(); // change window to mywindow
        };
      } else {
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();
      }

      // setTimeout(function() {
      //       mywindow.print();
      //       mywindow.close();
      //       }, 250);

      return true;
    },
    async searchItem() {
      await this.$axios.get(`/product?${this.queryString}`).then((response) => {
        this.isLoading = false;
        this.productslist = response.data.data;
        this.pagination.current = response.data.meta.current_page;
        this.pagination.total = response.data.meta.last_page;
      });
    },
    async getCategories() {
      await this.$axios.get("/category").then((response) => {
        this.categories = response.data;
      });
    },
    async getUnit() {
      await this.$axios.get("/unit").then((response) => {
        this.units = response.data;
      });
    },
    deleteProduct(item) {
      this.confirmation = true;
      this.prodid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`product/${this.prodid}`).then((res) => {
        this.alert = true;
        this.message = "Product Deleted Successfully";
        this.confirmation = false;
        this.getProducts();
      });
    },
    async getProducts() {
      this.isLoading = true;
      await this.$axios
        .get("/product?page=" + this.pagination.current)
        .then((response) => {
          this.isLoading = false;
          this.productslist = response.data.data;
          this.pagination.current = response.data.meta.current_page;
          this.pagination.total = response.data.meta.last_page;
        });
    },
    onPageChange() {
      this.getProducts();
    },
  },
  watch: {
    "form.category_id": function (val) {
      this.getChildOfCategory(val);
    },
  },
};
</script>

<style scoped>
.product-img {
  margin: 5px;
  border-radius: 5px;
}
</style>
