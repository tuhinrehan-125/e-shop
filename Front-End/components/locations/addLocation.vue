<template>
  <v-dialog v-model="dialog" persistent max-width="800px">
    <v-card>
      <v-card-title>
        Add Location
        <v-spacer></v-spacer>
        <v-btn text @click="closedialog">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-layout form>
              <v-flex md2>
                <v-subheader>Name</v-subheader>
              </v-flex>
              <v-flex md4>
                <v-text-field
                  outlined
                  dense
                  v-model="form.name"
                  :rules="reqRules"
                ></v-text-field>
              </v-flex>
              <v-flex md2>
                <v-subheader>Country</v-subheader>
              </v-flex>
              <v-flex md4>
                <v-text-field
                  outlined
                  dense
                  v-model="form.country"
                  :rules="reqRules"
                ></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout form>
              <v-flex md2>
                <v-subheader>State</v-subheader>
              </v-flex>
              <v-flex md4>
                <v-text-field
                  outlined
                  dense
                  v-model="form.state"
                  :rules="reqRules"
                ></v-text-field>
              </v-flex>
              <v-flex md2>
                <v-subheader>City</v-subheader>
              </v-flex>
              <v-flex md4>
                <v-text-field
                  outlined
                  dense
                  v-model="form.city"
                  :rules="reqRules"
                ></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout form>
              <v-flex md2>
                <v-subheader>Zip code</v-subheader>
              </v-flex>
              <v-flex md4>
                <v-text-field
                  outlined
                  dense
                  v-model="form.zip_code"
                  :rules="reqRules"
                ></v-text-field>
              </v-flex>
              <v-flex md2>
                <v-subheader>Mobile</v-subheader>
              </v-flex>
              <v-flex md4>
                <v-text-field
                  outlined
                  dense
                  v-model="form.mobile"
                ></v-text-field>
              </v-flex>
            </v-layout>
          </v-form>
        </v-container>
        <small>{{ $t("indicates_required_field") }}</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closedialog">
          {{ $t("close") }}
        </v-btn>
        <v-btn color="blue darken-1" text :loading="isLoading" @click="submitForm">
          {{ $t("save") }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "AddLocationForm",
  data() {
    return {
      isLoading:false,
      valid: true,
      reqRules: [v => !!v || this.$t("this_field_is_required")],
      form: {
        name: "",
        country: "",
        state: "",
        city: "",
        zip_code: "",
        mobile: "",
        business_id: this.$auth.user.data.business_id
      }
    };
  },
  computed: {
    dialog() {
      return this.$store.getters.modaltype == "add_locations"
        ? this.$store.getters.modal
        : false;
    },
    business_id() {
      return this.$auth.user.data.business_id;
    }
  },
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {
    closedialog() {
      this.$store.commit("SET_MODAL", { type: "", status: false });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        this.isLoading = true;
        await this.$axios
          .post("/business-location", this.form)
          .then(res => {
            this.isLoading = false;
            this.$refs.form.reset();
            let data = {
              alert: true,
              message: "Location Added Successfully",
              type: "success"
            };
            this.$store.commit("SET_ALERT", data);
            this.$store.commit("SET_MODAL", false);
            this.$emit("refresh");
          })
          .catch(error => {
            this.isLoading = false;
            if (error.response.data) {
              let err = Object.entries(error.response.data);
              for (let index = 0; index < err.length; index++) {
                const element = err[index][1].toString();
                let data = {
                  alert: true,
                  message: element,
                  type: "error"
                };
                this.$store.commit("SET_ALERT", data);
              }
            }
          });
      }
    }
  }
};
</script>

<style></style>
