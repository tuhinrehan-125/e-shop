<template>
  <div>
    <v-row align="left" class="mb-5 mt-1 ml-2" v-if="isEdit">
      <v-btn tile color="primary" to="/product/list">
        <v-icon left> mdi-arrow-left </v-icon>
        Go to product list
      </v-btn>
    </v-row>
    <v-row no-gutters>
      <v-col cols="12" sm="8" md="8" xl="9">
        <v-stepper v-model="curr" color="green" class="mb-70">
          <v-stepper-header class="overflow-x-auto">
            <v-stepper-step
              v-for="(step, n) in steps"
              :key="n"
              :complete="stepComplete(n + 1)"
              :step="n + 1"
              :rules="[(value) => !!step.valid]"
              :color="stepStatus(n + 1)"
              flat
            >
              {{ step.name }}
            </v-stepper-step>
          </v-stepper-header>
          <v-stepper-content v-for="(step, n) in steps" :step="n + 1" :key="n">
            <v-card min-height="380px">
              <v-card-text>
                <div v-if="step.name == 'Product Information'">
                  <v-form
                    :ref="'stepForm'"
                    v-model="step.valid"
                    lazy-validation
                  >
                    <v-row no-gutters>
                      <v-col cols="12" sm="12" md="12" xl="12">
                        <v-row>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-text-field
                              outlined
                              dense
                              label="Name"
                              :rules="step.rules"
                              v-model="form.name"
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-text-field
                              label="SKU"
                              placeholder="optional"
                              outlined
                              dense
                              v-model="form.sku"
                            ></v-text-field>
                          </v-col>
                        </v-row>
                        <v-row no-gutters>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-select
                              :rules="step.rules"
                              v-model="form.category_id"
                              :items="categories"
                              item-text="name"
                              item-value="id"
                              dense
                              outlined
                              label="Category"
                            ></v-select>
                          </v-col>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-select
                              v-model="form.subcategory_id"
                              :items="subcats"
                              item-text="name"
                              item-value="id"
                              dense
                              outlined
                              label="Subcategory"
                            ></v-select>
                          </v-col>
                        </v-row>
                        <v-row no-gutters>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-select
                              v-model="form.brand_id"
                              :items="brands"
                              item-text="name"
                              item-value="id"
                              dense
                              outlined
                              label="Brand"
                            ></v-select>
                          </v-col>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-select
                              :rules="step.rules"
                              v-model="form.unit_id"
                              :items="units"
                              item-text="name"
                              item-value="id"
                              dense
                              outlined
                              label="Unit"
                            ></v-select>
                          </v-col>
                        </v-row>
                        <v-row no-gutters>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-select
                              v-model="form.barcode_type"
                              :items="btypes"
                              dense
                              outlined
                              :rules="step.rules"
                              label="Barcode Type"
                            ></v-select>
                          </v-col>
                          <v-col cols="12" sm="6" md="6" xl="6">
                            <v-text-field
                              outlined
                              dense
                              type="number"
                              :rules="step.rules"
                              v-model="form.alert_quantity"
                              label="Alert Quantity"
                            ></v-text-field>
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-row>
                  </v-form>
                </div>
                <template v-if="step.name == 'Pricing Information'">
                  <v-form
                    :ref="'stepForm'"
                    v-model="step.valid"
                    lazy-validation
                  >
                    <v-row no-gutters>
                      <v-col cols="12" sm="6" md="6" xl="6">
                        <v-text-field
                          v-model="form.purchase_price"
                          outlined
                          dense
                          :rules="step.rules"
                          label="Purchase Price"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xl="6">
                        <v-text-field
                          v-model="form.sell_price"
                          outlined
                          dense
                          :rules="step.rules"
                          label="Sell Price"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row no-gutters>
                      <v-col cols="12" sm="6" md="6" xl="6">
                        <v-select
                          v-model="form.tax_method"
                          :items="tax_methods"
                          dense
                          outlined
                          :rules="step.rules"
                          label="Tax Method"
                        ></v-select>
                      </v-col>
                      <v-col cols="12" sm="6" md="6" xl="6">
                        <v-text-field
                          v-model="form.tax"
                          outlined
                          dense
                          label="Tax"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-form>
                </template>
                <template v-if="step.name == 'Product Variations'">
                  <v-form
                    :ref="'stepForm'"
                    v-model="step.valid"
                    lazy-validation
                  >
                    <v-row no-gutters>
                      <v-col cols="12" sm="6" md="6" xl="6">
                        <v-radio-group v-model="form.type" row>
                          <v-radio
                            label="Single Product"
                            value="single"
                          ></v-radio>
                          <v-radio
                            label="Variation Product"
                            value="variable"
                          ></v-radio>
                        </v-radio-group>
                      </v-col>
                    </v-row>
                    <div class="variation-form" v-if="form.type == 'variable'">
                      <h2 class="overline variation-title mt-5 mb-5">
                        Add variation
                      </h2>
                      <v-layout
                        row
                        v-for="(variation, index) in form.product_variation"
                        :key="index"
                        no-gutters
                      >
                        <v-col cols="12" sm="6" md="3">
                          <v-text-field
                            outlined
                            dense
                            label="name"
                            required
                            v-model="variation.name"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                          <v-text-field
                            outlined
                            dense
                            label="Purchase price"
                            required
                            v-model="variation.purchase_price"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                          <v-text-field
                            outlined
                            dense
                            label="Tax"
                            required
                            v-model="variation.sell_price"
                          ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                          <v-text-field
                            outlined
                            dense
                            label="Sell price"
                            required
                            v-model="variation.tax"
                          ></v-text-field>
                          <v-btn
                            text
                            icon
                            dark
                            class="variation-remove"
                            color="red"
                            @click="removeVarition(index)"
                            ><v-icon small> mdi-trash-can </v-icon></v-btn
                          >
                        </v-col>
                      </v-layout>
                    </div>
                    <v-row v-if="form.type == 'variable'">
                      <v-col cols="12" md="12">
                        <v-btn
                          dark
                          small
                          class="float-right"
                          @click="addVariation"
                          ><v-icon dark> mdi-plus </v-icon> Add</v-btn
                        >
                      </v-col>
                    </v-row>
                  </v-form>
                </template>
                <template v-if="step.name == 'Opening Stock'">
                  <v-form
                    :ref="'stepForm'"
                    v-model="step.valid"
                    lazy-validation
                  >
                    <v-row no-gutters>
                      <v-col cols="12" sm="6" md="6" xl="6">
                        <v-radio-group v-model="form.add_opening_stock" row>
                          <v-radio
                            label="Doesn't have opening stock"
                            value="0"
                          ></v-radio>
                          <v-radio
                            label="Add opening stock"
                            value="1"
                          ></v-radio>
                        </v-radio-group>
                      </v-col>
                    </v-row>
                    <div v-if="form.add_opening_stock == '1'">
                      <v-row no-gutters class="mb-10">
                        <v-col
                          cols="6"
                          sm="6"
                          md="6"
                          xl="6"
                          v-for="(location, index) in form.opening_stocks"
                          :key="index"
                        >
                          <v-card class="isbordered" flat>
                            <v-card-text>
                              <v-row no-gutters>
                                <v-col cols="12" md="6" sm="6" xl="6">
                                  <h3>{{ location.name }}</h3>
                                  <p>{{ location.address }}</p>
                                </v-col>
                                <v-col cols="12" md="6" sm="6" xl="6">
                                  <p>Quantity</p>
                                  <v-text-field
                                    v-model="location.quantity"
                                    outlined
                                    dense
                                    id="oqty"
                                  ></v-text-field>
                                </v-col>
                              </v-row>
                            </v-card-text>
                          </v-card>
                        </v-col>
                      </v-row>
                    </div>
                  </v-form>
                </template>
                <v-row no-gutters class="step-actions">
                  <v-col cols="12" sm="12" md="12" xl="12">
                    <v-btn
                      v-if="n + 1 < lastStep"
                      color="primary"
                      @click="validate(n)"
                      :disabled="!step.valid"
                      >Continue</v-btn
                    >
                    <v-btn
                      v-else
                      color="success"
                      @click="done()"
                      :loading="isLoading"
                      >Submit</v-btn
                    >
                    <v-btn text v-if="curr > 1" @click="curr = n">Back</v-btn>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-stepper-content>
        </v-stepper>
      </v-col>
      <v-col cols="12" sm="4" md="4" xl="3">
        <v-card min-height="490px">
          <v-card-text>
            <v-row align="center" justify="center">
              <v-col cols="12">
                <div class="imageuplaod text-center">
                  <vue-upload-multiple-image
                    @upload-success="uploadImageSuccess"
                    @before-remove="beforeRemove"
                    @edit-image="editImage"
                    :data-images="form.images"
                    idUpload="myIdUpload"
                    editUpload="myIdEdit"
                    dragText="Drag or select picture"
                    browseText="Browse"
                    markIsPrimaryText=""
                    primaryText=""
                  ></vue-upload-multiple-image>
                </div>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import VueUploadMultipleImage from "vue-upload-multiple-image";
export default {
  name: "AddProduct",
  components: {
    VueUploadMultipleImage,
  },
  props: ["data"],
  data() {
    return {
      isLoading: false,
      curr: 1,
      isEdit: false,
      lastStep: 4,
      steps: [
        {
          name: "Product Information",
          rules: [(v) => !!v || "Required."],
          valid: true,
        },

        {
          name: "Pricing Information",
          rules: [(v) => !!v || "Required."],
          valid: true,
        },
        {
          name: "Product Variations",
          valid: true,
        },
        {
          name: "Opening Stock",
          valid: true,
        },
      ],
      tax_methods: ["Inclusive", "Exclusive"],
      valid: false,
      stepForm: [],
      checkbox: false,
      btypes: ["C39", "C128", "EAN13", "EAN8", "UPCA", "UPCE"],
      form: {
        name: "",
        type: "single",
        unit_id: "",
        brand_id: "",
        category_id: "",
        subcategory_id: "",
        barcode_type: "",
        enable_stock: false,
        alert_quantity: "",
        sku: "",
        product_description: "",
        weight: "",
        purchase_price: "",
        sell_price: "",
        tax_method: "",
        images: [],
        tax: "",
        add_opening_stock: "0",
        product_variation: [
          {
            name: "",
            purchase_price: "",
            sell_price: "",
            tax: "",
          },
        ],
        opening_stocks: [],
      },
      prodid: "",
      brands: [],
      categories: [],
      productslist: [],
      categories: [],
      subcategories: [],
      units: [],
      subunits: [],
      parents: [],
      variations: [],
      allCats: [],
      haveSubcat: false,
      subcats: [],
      items: [
        {
          name: "",
          quantity: 0,
          amount: 0,
          total: 0,
        },
      ],
    };
  },
  computed: {
    user_business_location() {
      return this.$auth.user.data.user_business_location;
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getBrands();
    this.getCategories();
    this.getUnit();
    for (let index = 0; index < this.user_business_location.length; index++) {
      this.form.opening_stocks.push({
        location_id: this.user_business_location[index].id,
        quantity: "",
        name: this.user_business_location[index].name,
        address:
          this.user_business_location[index].state +
          "," +
          this.user_business_location[index].city +
          "," +
          this.user_business_location[index].country +
          "-" +
          this.user_business_location[index].zip_code,
      });
    }
    if (Object.keys(this.data).length > 1) {
      this.isEdit = true;
      this.form = this.data;
      this.form.type = this.data.type;
    }
  },
  watch: {
    "form.category_id": function (val) {
      this.getSubCategories(val);
    },
  },
  methods: {
    uploadImageSuccess(formData, index, fileList) {
      this.form.images = fileList;
    },
    beforeRemove(index, done, fileList) {
      var r = confirm("remove image");
      if (r == true) {
        this.form.images.splice(this.form.images.indexOf(index), 1);
        done();
      } else {
      }
    },
    editImage(formData, index, fileList) {
      setTimeout(() => {
        this.form.images = fileList;
      }, 2000);
    },
    addVariation() {
      this.form.product_variation.push({
        name: "",
        purchase_price: "",
        sell_price: "",
        tax: "",
      });
    },
    removeVarition(index) {
      this.form.product_variation.splice(index, 1);
    },
    imageUpload() {
      this.form.image = this.$refs.file.files[0];
    },
    stepComplete(step) {
      return this.curr > step;
    },
    stepStatus(step) {
      return this.curr > step ? "green" : "blue";
    },
    validate(n) {
      this.steps[n].valid = false;
      let v = this.$refs.stepForm[n].validate();
      if (v) {
        this.steps[n].valid = true;
        // continue to next
        this.curr = n + 2;
      }
    },
    async done() {
      this.isLoading = true;
      let formData = new FormData();
      for (var key in this.form) {
        formData.append(key, this.form[key]);
      }
      formData.append(
        "opening_stocks",
        JSON.stringify(this.form.opening_stocks)
      );
      if (this.isEdit) {
        formData.append("_method", "PATCH");
        await this.$axios
          .post(`product/${this.data.id}`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            this.isLoading = false;
            let data = {
              alert: true,
              message: "Product Updated Successfully",
              type: "success",
            };
            this.$store.commit("SET_ALERT", data);
            this.$store.commit("SET_MODAL", true);
            this.$router.push({ name: "product-list" });
          })
          .catch((err) => {
            console.log(err);
            this.isLoading = false;
          });
      } else {
        await this.$axios
          .post("product", this.form)
          .then((response) => {
            console.log(response);
            if (response.status == 201) {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Product Addedd Successfully",
                type: "success",
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", true);
              this.$router.push({ name: "product-list" });
            } else {
              this.isLoading = false;
              let data = {
                alert: true,
                message: "Server Error, Try again later",
                type: "error",
              };
              this.$store.commit("SET_ALERT", data);
            }
          })
          .catch((error) => {
            let data = {
              alert: true,
              message: "Server Error, Try again later",
              type: "error",
            };
            this.$store.commit("SET_ALERT", data);
            this.isLoading = false;
          });
      }
    },
    async getBrands() {
      await this.$axios.get("/brand").then((response) => {
        this.brands = response.data;
      });
    },
    async getUnit() {
      await this.$axios.get("/unit").then((response) => {
        this.units = response.data;
      });
    },
    async getCategories() {
      await this.$axios.get("/category").then((response) => {
        this.allCats = response.data;
        this.categories = response.data.filter(function (data) {
          return data.parent_id == 0;
        });
      });
    },
    getSubCategories(val) {
      this.subcats = [];
      this.allCats.map((data) => {
        if (val == data.parent_id) {
          this.subcats.push(data);
        }
      });
    },
    async getVariations() {
      await this.$axios.get("/product-variation").then((response) => {
        this.variations = response.data;
      });
    },
    async getChildOfUnit(val) {
      await this.$axios.get(`get-subunits/${val}`).then((response) => {
        this.subunits = response.data;
      });
    },
  },
};
</script>

<style lang="scss" scoped>
h3 {
  color: #000;
  line-height: 1.5em;
}
.v-stepper__header {
  box-shadow: none;
  display: inline-flex;
}
.variation-title {
  text-align: center;
  font-size: 15px !important;
  font-weight: 600;
}
.variation-remove {
  float: right;
  margin-top: -25px;
}
.imageuplaod {
  display: flex;
  justify-content: center;
  position: relative;
  top: 100px;
}
.step-actions {
  position: absolute;
  bottom: 0px;
  left: 0px;
}
.isbordered {
  border: 1px solid #ebebeb;
}
</style>
