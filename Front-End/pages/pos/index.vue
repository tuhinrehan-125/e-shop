<template>
  <v-container fluid grid-list-xl class="pa-0">
     <v-dialog v-model="alert" max-width="783">
        <v-card>
          <v-card-title>
            Create Payment
          </v-card-title>
          <v-card-text class="pb-6 pt-12 text-center">
            <v-btn class="mr-3" text @click="alert = false"> No </v-btn>
            <v-btn color="success"> Yes </v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>

    <v-row class="pos">
      <v-col cols="12" sm="6" md="6" class="pos-left">
        <v-card flat>
          <v-card-text class="pa-0">
            <v-row>
              <v-col
                cols="6"
                sm="6"
                md="6"
                class="d-flex justify-start ma-0 pa-4 settings-menu"
              >
               <v-app-bar-nav-icon color="#000" @click="setDrawer(!drawer)"></v-app-bar-nav-icon>
              </v-col>
              <v-col
                cols="6"
                sm="6"
                md="6"
                class="d-flex justify-end ma-0 pa-4 settings-menu"
              >
                <v-btn text icon color="blue lighten-2">
                  <v-icon>mdi-allergy</v-icon>
                </v-btn>
                <v-btn text icon color="red lighten-2">
                  <v-icon>mdi-bank-off</v-icon>
                </v-btn>
                <v-btn text icon color="green lighten-2">
                  <v-icon>mdi-bookmark-plus</v-icon>
                </v-btn>
                <v-btn text icon color="cayan lighten-2">
                  <v-icon>mdi-calculator</v-icon>
                </v-btn>
              </v-col>
              <v-col cols="12" sm="12" md="12">
                <v-row class="pa-3">
                  <v-col cols="12" sm="12" md="6">
                    <v-autocomplete
                      v-model="selectedProduct"
                      :items="searchproductLists"
                      :loading="prductLoading"
                      :search-input.sync="productSearch"
                      outlined
                      flat
                      dense
                      clearable
                      hide-no-data
                      hide-selected
                      height="30px"
                      item-text="product"
                      item-value="product_id"
                      label="Type To Search Product"
                      placeholder="Type To Search Product"
                      return-object
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-autocomplete
                      :items="business_locations"
                      label="Select Store"
                      outlined
                      flat
                      dense
                      required
                      v-model="form.store"
                      item-text="name"
                      item-value="id"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-select
                      :items="customers"
                      label="Select customer"
                      outlined
                      flat
                      dense
                      required
                      v-model="form.customer"
                      item-text="name"
                      item-value="id"
                    ></v-select>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row class="pa-1">
              <v-col cols="12" sm="12" md="12" class="pb-0">
                <v-data-table
                  :headers="headers"
                  :items="cartItems"
                  fixed-header
                  height="400px"
                  :hide-default-footer="true"
                >
                  <template v-slot:[`item.quantity`]="{ item }">
                    <vue-number-input
                      :value="item.quantity"
                      @input="qtyChange($event, cartItems.indexOf(item))"
                      @change="qtyChange($event, cartItems.indexOf(item))"
                      size="small"
                      inline
                      controls
                    ></vue-number-input>
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <v-icon
                      small
                      @click="removeItem(item, cartItems.indexOf(item))"
                    >
                      mdi-delete
                    </v-icon>
                  </template>
                </v-data-table>
              </v-col>
              <div class="flex-container">
                <div class="flex-left">
                  <v-row class="pa-8">
                    <v-col cols="12" md="4">
                      <label>Tax (%)</label>
                      <v-text-field
                        dense
                        outlined
                        size="small"
                        type="number"
                        v-model="form.tax"
                        @keyup="addTax($event.target.value)"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                      <label>Discount (%)</label>
                      <v-text-field
                        dense
                        outlined
                        size="small"
                        type="number"
                        v-model="form.discount"
                        @keyup="addDiscount($event.target.value)"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4">
                      <label>Shipping</label>
                      <v-text-field
                        dense
                        outlined
                        size="small"
                        type="number"
                        v-model="form.shipping_cost"
                        @keyup="addShippingCost($event.target.value)"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </div>
                <div class="flex-right">
                  <v-row class="pa-4">
                    <v-col cols="12" md="12">
                      <v-list>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title>Items</v-list-item-title>
                          </v-list-item-content>
                          <v-list-item-action>{{
                            cartItems.length
                          }}</v-list-item-action>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title>Sub Total</v-list-item-title>
                          </v-list-item-content>
                          <v-list-item-action>{{
                            subTotalPrice
                          }}</v-list-item-action>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title>( + ) Tax</v-list-item-title>
                          </v-list-item-content>
                          <v-list-item-action>{{tax_amount}}</v-list-item-action>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title
                              >( + ) Shipping charge</v-list-item-title
                            >
                          </v-list-item-content>
                          <v-list-item-action>{{shipping_cost}}</v-list-item-action>
                        </v-list-item>
                        <v-divider />
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title><b>Total</b></v-list-item-title>
                          </v-list-item-content>
                          <v-list-item-action><b>{{totalPrice}}</b></v-list-item-action>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title
                              >( - ) Discount</v-list-item-title
                            >
                          </v-list-item-content>
                          <v-list-item-action>{{discount_amount}}</v-list-item-action>
                        </v-list-item>
                        <v-divider />
                        <v-list-item>
                          <v-list-item-content>
                            <v-list-item-title
                              ><b>Net Total</b></v-list-item-title
                            >
                          </v-list-item-content>
                          <v-list-item-action><b>{{grandTotal}}</b></v-list-item-action>
                        </v-list-item>
                      </v-list>
                    </v-col>
                  </v-row>
                </div>
              </div>
              <div class="flex-container">
                <v-row class="mt-5">
                  <v-col cols="12" class="d-flex justify-end">
                    <v-btn depressed color="error" class="mr-5"> Reset </v-btn>
                    <v-btn depressed color="primary" @click="paynow"> Pay now </v-btn>
                  </v-col>
                </v-row>
              </div>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
      <v-divider vertical></v-divider>
      <v-col cols="12" sm="6" md="6" class="pos-right">
        <v-row>
          <v-col cols="12" md="12">
            <v-card flat>
              <v-card-text>
                <v-row>
                  <v-col cols="3" xs="6">
                    <v-autocomplete
                      :items="categories"
                      label="Category"
                      outlined
                      flat
                      dense
                      required
                      v-model="form.category"
                      item-text="name"
                      item-value="id"
                      clearable
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="3" xs="6">
                    <v-autocomplete
                      :items="brands"
                      label="Brand"
                      outlined
                      flat
                      dense
                      required
                      v-model="form.brand"
                      item-text="name"
                      item-value="id"
                      clearable
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="3" xs="6">
                    <v-btn outlined block color="secondary"> Popular </v-btn>
                  </v-col>
                  <v-col cols="3" xs="6">
                    <v-btn outlined block color="success"> Preffered </v-btn>
                  </v-col>
                </v-row>
                <v-row no-gutters class="pos-items" v-if="products.length>0">
                  <v-col
                    v-for="(product, i) in products"
                    :key="i"
                    class="d-flex child-flex"
                    cols="4"
                    xl="2"
                    xs="4"
                    sm="4"
                    md="3"
                  >
                    <v-item v-slot="{ active, toggle }">
                      <v-card
                        flat
                        :color="active ? 'primary' : ''"
                        @click="addtoCart(product)"
                        light
                        class="pro-card"
                      >
                        <v-img
                          :src="product.image"
                          :lazy-src="product.image"
                          aspect-ratio="1"
                          class="grey lighten-2 ma-3"
                        >
                          <template v-slot:placeholder>
                            <v-row
                              class="fill-height ma-0"
                              align="center"
                              justify="center"
                            >
                              <v-progress-circular
                                indeterminate
                                color="grey lighten-5"
                              ></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>

                        <div class="pro-details">
                          <b>{{ product.name }}</b>
                          <p class="pb-2">{{ product.sell_price }}</p>
                        </div>

                        <v-scroll-y-transition>
                          <div
                            v-if="active"
                            class="display-3 flex-grow-1 text-center"
                          >
                            Active
                          </div>
                        </v-scroll-y-transition>
                      </v-card>
                    </v-item>
                  </v-col>
                </v-row>
                <v-row v-else>
                   <v-col
                    v-for="i in 12"
                    :key="i"
                    class="d-flex child-flex"
                    cols="4"
                    xl="2"
                    xs="4"
                    sm="4"
                    md="3"
                  >
                    <v-skeleton-loader
                    class="mx-auto"
                      type="image, list-item-two-line"
                    ></v-skeleton-loader>
                   </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Vue from "vue";
import VueNumberInput from "@chenfengyuan/vue-number-input";
import VueHtmlToPaper from "vue-html-to-paper";
const options = {
  name: "_blank",
  specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
  styles: [
    "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
  ],
};

Vue.use(VueHtmlToPaper, options);
import { mapState,mapMutations } from "vuex";
export default {
  components: {
    VueNumberInput,
  },

  name: "pos",
  middleware: "auth",
  head: {
    title: "POS",
  },
  layout: "pos",
  data() {
    return {
      form: {
        store: "",
        category:null,
        brand:null
      },
      baseStyles: {
        marginTop: "20px",
        height: "50px",
      },
      pagination: {},
      advancetaken: 0.0,
      purchasecommission: 0,
      advance_payout: 0.0,
      qty: 1,
      amount: "",
      active: "",
      tab: "",
      message: "",
      alert: false,
      client_id: null,
      items: [],
      prductLoading: false,
      selectedProduct: '',
      selectedCustomer: null,
      selectedClient: null,
      productSearch: null,
      clientSearch: null,
      products: [],
      searchproductLists:[],
      customerLoading: false,
      clientLoading: false,
      customerSearch: null,
      customers: [],
      categories: [],
      brands: [],
      peoducts: [],
      invoice_no: "",
    };
  },
  created(){
    this.setDrawer(false)
  },
  computed: {
    ...mapState(["drawer"]),
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("item_name"),
          value: "product",
          align: "left",
          width: "120px",
        },
        {
          sortable: false,
          text: this.$t("price"),
          value: "price",
          align: "center",
          width: "100px",
        },
        {
          sortable: false,
          text: this.$t("quantity"),
          value: "quantity",
          align: "center",
          width: "150px",
        },
        {
          sortable: false,
          text: this.$t("total"),
          value: "subtotal",
          align: "center",
          width: "110px",
        },

        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
          width: "100px",
        },
      ];
    },
    business_locations() {
      return this.$auth.user.data.user_business_location;
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
    cartItems() {
      let products = this.$store.getters["pos/getcartItems"];
      return products;
    },
    subTotalPrice() {
      return this.$store.getters["pos/subTotalPrice"];
    },
    tax_amount() {
      return this.$store.getters["pos/amountOfTax"];
    },
    discount_amount() {
      return this.$store.getters["pos/amountOfDiscount"];
    },
    shipping_cost() {
      return this.$store.getters["pos/amountOfShippingCost"];
    },
    totalPrice() {
      return Math.round(this.$store.getters["pos/totalPrice"]);
    },
    grandTotal() {
      let grandtotal = this.$store.getters["pos/netTotalPrice"];
      return Math.round(grandtotal);
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.posItems();
  },

  methods: {
    ...mapMutations({
      setDrawer: "SET_DRAWER"
    }),
    paynow(){
      this.alert=true
    },
    async posItems() {
      const [category, brand, product, customer] = await Promise.all([
        this.$axios.get("category"),
        this.$axios.get("brand"),
        this.$axios.get("/pos/products"),
        this.$axios.get("/contact?type=customer"),
      ]);
      this.customers = customer.data;
      this.categories = category.data;
      this.brands = brand.data;
      this.products = product.data.data;
      this.pagination.current = product.data.meta.current_page;
      this.pagination.total = product.data.meta.last_page;
    },
    makeSell() {
      if (this.client_id == null) {
        this.type = "error";
        this.alert = true;
        this.message = "Please Select a client";
        return;
      }
      this.$axios
        .post("/order", {
          products: this.cartItems,
          commission: this.commission,
          advance_payout: this.advancepayout,
          sub_total: this.subTotal,
          total_price: this.totalPrice,
          grand_total: this.grandTotal,
          client: this.client_id,
        })
        .then((res) => {
          this.type = "success";
          this.alert = true;
          this.message = "Products saved into invoice";
          this.$htmlToPaper("printMe");
          this.advancetaken = 0;
          this.client_id = "";
          this.advance_payout = 0;
          this.purchasecommission = 0;
          this.$store.commit("cart/SET_CART_PRODUCTS", []);
          this.$store.commit("cart/SET_ADVANCE_PAYOUT", 0);
        })
        .catch((err) => {
          this.type = "error";
          this.alert = true;
          this.message = "Server Error";
        });
    },
    qtyChange(e, i) {
      let qty = 0;
      if (typeof e === "object" && e !== null) {
        qty = e.target.value;
      } else {
        qty = e;
      }
      this.$store.dispatch("pos/updateCartItem", {
        qty: qty,
        index: i,
        type: "qtychange",
      });
    },
    addTax(val) {
      this.$store.dispatch("pos/updateCartItem", {
        tax: val,
        type: "tax",
      });
    },
    addDiscount(val) {
      this.$store.dispatch("pos/updateCartItem", {
        discount: val,
        type: "discount",
      });
    },
    addShippingCost(val) {
      this.$store.dispatch("pos/updateCartItem", {
        shipping_cost: val,
        type: "shipping_cost",
      });
    },

    removeItem(item, index) {
      this.$store.dispatch("pos/removeCartItem", {
        product: item,
        index: index,
      });
    },

    async addtoCart(product) {
      if (this.form.store == "") {
        let data = {
          alert: true,
          message: "Please select store first",
          type: "error",
        };
        this.$store.commit("SET_ALERT", data);
        return;
      }
      //get product info from server
      await this.$axios
        .get(`pos/product_info/${product.variation_id}/${this.form.store}`)
        .then((res) => {
          //if the store dont have stock
          if (res.data.success == false) {
            let data = {
              alert: true,
              message: "Product Out of stock",
              type: "error",
            };
            this.$store.commit("SET_ALERT", data);
            return;
          } else {
            //if the store have stock make dispatch to store
            this.$store.dispatch("pos/addItemToCart", {
              product: res.data.data.product_name,
              product_id: res.data.data.product_id,
              quantity: 1,
              sell_price: res.data.data.product_sell_price,
            });
          }
        });
    },
  },
  watch: {
    'form.category':function(val) {
      this.products = []
      let data={
        category_id: val, brand_id: this.form.brand
      }
       this.$axios.post("/product/search-by-category-brand", data)
        .then(res => {
          this.products = res.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    'form.brand':function(val) {
       this.products = []
       this.$axios.post("/product/search-by-category-brand", { brand_id: val,category_id:this.form.category})
        .then(res => {
          this.products = res.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    purchasecommission(val) {
      let commission = val;
      this.$store.commit("cart/SET_COMMISSION", commission);
    },
    selectedCustomer(val) {
      this.purchasecommission = val.commission;
    },
    selectedProduct(val) {
      if (val) {
      this.addtoCart(val)
      }
    },
    productSearch(val) {
      if(val){
      this.prductLoading = true;
      this.$axios.post("/product/search", { name: val, location_id:this.form.store })
        .then(res => {
          this.searchproductLists = res.data;
          this.prductLoading = false;
        })
        .catch(err => {
          console.log(err);
          this.prductLoading = false;
        });
      }

    },
    cartItems(val) {
      let ac = this;
      if (val) {
        setTimeout(function () {
          ac.selectedProduct = null;
        },1000);
      }
    },
    clientSearch(val) {
      this.clientLoading = true;
      this.$axios
        .get("/client-search?name=" + val)
        .then((res) => {
          this.clients = res.data;
          this.clientLoading = false;
        })
        .catch((err) => {
          console.log(err);
          this.clientLoading = false;
        });
    },
    customerSearch(val) {
      this.customerLoading = true;
      this.$axios
        .get("/customer-search?name=" + val)
        .then((res) => {
          this.customers = res.data;
          console.log(res.data.commission);
          this.customerLoading = false;
        })
        .catch((err) => {
          console.log(err);
          this.customerLoading = false;
        });
    },
    client_id(val) {
      let client = this.clients.find((item) => {
        return val == item.id;
      });
      this.purchasecommission = client.commission_rate;
      this.selectedClient = client;
      this.advancetaken = client.due;
      this.$store.commit("cart/SET_ADVANCE", this.advancetaken);
    },
    advance_payout(val) {
      this.$store.commit("cart/SET_ADVANCE_PAYOUT", val);
    },
  },
};
</script>

<style lang="scss" scoped>
.pos-items {
  border-top: 1px solid #ebebeb;
  border-left: 1px solid #ebebeb;
  max-height: 568px;
  overflow: auto;
}
.number-input--inline {
  width: 105px;
}
.v-data-table .v-text-field {
  width: 100px;
  height: 10px;
}

#printMe {
  display: none;
}
.v-text-field.v-text-field--solo .v-input__control {
  min-height: 10px;
}
.total-price {
  text-align: center;
  color: #000;
  margin-bottom: 15px;
  padding: 10px;
  font-size: 1.6em;
}
.pos-actions {
  position: fixed;
  bottom: 15px;
  left: 15px;
}
.pos-left .settings-menu {
  padding: 20px;
  border-bottom: 1px solid #ebebeb;
}
.pos-left .v-input {
  height: 30px;
}
.v-data-table {
  border-radius: 0px;
}
.flex-container {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  width: 100%;
  padding: 0px 12px;
}
.flex-left {
  width: 50%;
  border-left: 1px solid #ebebeb;
  border-right: 1px solid #ebebeb;
  border-bottom: 1px solid #ebebeb;
}
.theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
    background-color: #fff;
}
.flex-right {
  width: 50%;
  border-right: 1px solid #ebebeb;
  border-bottom: 1px solid #ebebeb;
}
.v-card {
  border-radius: 0px;
}
.pro-card {
  border-right: 1px solid #ebebeb;
  border-bottom: 1px solid #ebebeb;
}
.pro-details {
  text-align: center;
}
.pro-details p {
  margin-bottom: 0px !important;
}
.v-list-item {
  min-height: 10px;
  max-height: 30px;
}
.v-list-item__content {
  padding: 3px 0;
}
.no-gutters > .col,
.no-gutters > [class*="col-"] {
  padding-right: 0px !important;
  padding-bottom: 0px !important;
}
</style>
