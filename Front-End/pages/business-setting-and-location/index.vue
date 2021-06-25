<template>
  <v-container grid-list-sm>
    <base-material-snackbar v-model="alert" :type="type">
      {{ message }}
    </base-material-snackbar>
    <div class="mt-3 mb-10 text-center">
      <h2 class="heading">Business setting and location</h2>
      <v-divider width="250" style="margin: 0 auto" color="#ccc" />
    </div>
    <v-row>
      <v-col md="6" lg="6" xl="6" sm="12" class="mb-5">
        <v-card>
          <div v-for="(row, index) in form.business_locations" :key="index">
            <v-card-title><b>New Business Location</b></v-card-title>
            <v-card-text>
              <v-form lazy-validation>
                <v-layout row>
                  <v-flex md2>
                    <v-subheader>Name</v-subheader>
                  </v-flex>
                  <v-flex md4>
                    <v-text-field
                      outlined
                      dense
                      v-model="row.name"
                    ></v-text-field>
                  </v-flex>
                  <v-flex md2>
                    <v-subheader>Country</v-subheader>
                  </v-flex>
                  <v-flex md4>
                    <v-text-field
                      outlined
                      dense
                      v-model="row.country"
                    ></v-text-field>
                  </v-flex>
                </v-layout>
                <v-layout row>
                  <v-flex xl2>
                    <v-subheader>State</v-subheader>
                  </v-flex>
                  <v-flex xl4>
                    <v-text-field
                      outlined
                      dense
                      v-model="row.state"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xl2>
                    <v-subheader>City</v-subheader>
                  </v-flex>
                  <v-flex xl4>
                    <v-text-field
                      outlined
                      dense
                      v-model="row.city"
                    ></v-text-field>
                  </v-flex>
                </v-layout>
                <v-layout row>
                  <v-flex xl2>
                    <v-subheader>Zip code</v-subheader>
                  </v-flex>
                  <v-flex xl4>
                    <v-text-field
                      outlined
                      dense
                      v-model="row.zip_code"
                    ></v-text-field>
                  </v-flex>
                  <v-flex xl2>
                    <v-subheader>Mobile</v-subheader>
                  </v-flex>
                  <v-flex xl4>
                    <v-text-field
                      outlined
                      dense
                      v-model="row.mobile"
                    ></v-text-field>
                  </v-flex>
                </v-layout>
              </v-form>
            </v-card-text>
          </div>
          <v-row class="ml-2">
            <v-col md="6" lg="6" xl="6" sm="12">
              <v-btn tile color="indigo" @click="addRow">
                Add more location
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
      <v-col md="6" lg="6" xl="6" sm="12">
        <v-card>
          <v-card-title><b>Add your business settings</b></v-card-title>
          <v-card-text>
            <v-form lazy-validation>
              <v-layout row>
                <v-flex xl2>
                  <v-subheader>Currency</v-subheader>
                </v-flex>
                <v-flex xl4>
                  <v-select
                    :items="currencies"
                    v-model="form.currency_id"
                    item-text="currency"
                    item-value="id"
                    dense
                    outlined
                  ></v-select>
                </v-flex>
              </v-layout>
            </v-form>
          </v-card-text>
        </v-card>
        <v-layout row class="mt-10">
          <v-flex xl12>
            <v-btn
              tile
              color="success"
              class="float-right mr-5"
              :loading="isLoading"
              @click="addLocation"
            >
              Save
            </v-btn>
          </v-flex>
        </v-layout>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  middleware({ $gates, redirect }) {
    if (!$gates.hasRole("admin")) {
      return redirect("/dashboard");
    }
  },
  name: "Add-business-setting-location",
  layout: "register",
  head: {
    title: "Set up business setting and location"
  },
  components: {},
  data() {
    return {
      alert: false,
      type: "success",
      message: "",
      isLoading: false,
      currencies: [],
      form: {
        business_id: this.$auth.user.data.business_id,
        currency_id: "",
        business_locations: [
          {
            name: "",
            country: "",
            state: "",
            city: "",
            zip_code: "",
            mobile: ""
          }
        ]
      }
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {
    this.getAllCurrency();
  },
  methods: {
    addRow: function() {
      this.form.business_locations.push({
        name: "",
        country: "",
        state: "",
        city: "",
        zip_code: "",
        mobile: ""
      });
    },
    async addLocation() {
      this.isLoading = true;
      await this.$axios
        .post("/business-setting-and-location", this.form)
        .then(response => {
          this.isLoading = false;
          this.$router.push("/dashboard");
        })
        .catch(error => {
          this.isLoading = false;
          if (error.response.data) {
            let err = Object.entries(error.response.data);
            for (let index = 0; index < err.length; index++) {
              const element = err[index][1].toString();
              this.type = "error";
              this.alert = true;
              this.message = element;
            }
          }
        });
    },
    async getAllCurrency() {
      await this.$axios.get("/get-currency").then(response => {
        this.currencies = response.data.data;
      });
    }
  }
};
</script>

<style scoped>
.heading {
  text-transform: capitalize;
}
</style>
