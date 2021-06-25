<template>
  <v-dialog v-model="dialog" persistent max-width="800px">
    <v-card>
      <v-card-title>
        Add customer
        <v-spacer></v-spacer>
        <v-btn text @click="closedialog">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
          <v-row no-gutters>
            <v-col  cols="12" md="6">
              <v-text-field
                class="smalltext"
                :label="$t('customer_name')"
                required
                outlined
                dense
                v-model="form.name"
                :rules="[v => !!v || 'Customer name is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('email')"
                v-model="form.email"
                outlined
                dense
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('tax_number')"
                v-model="form.tax_number"
                outlined
                dense
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('phone_no')"
                v-model="form.mobile"
                outlined
                dense
                 :rules="[v => !!v || 'Mobile No is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('country')"
                v-model="form.country"
                outlined
                dense
                :rules="[v => !!v || 'Country is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('city')"
                v-model="form.city"
                outlined
                dense
                :rules="[v => !!v || 'City is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('state')"
                v-model="form.state"
                outlined
                dense
                :rules="[v => !!v || 'State is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('zip_code')"
                v-model="form.zip_code"
                outlined
                dense
                :rules="[v => !!v || 'Zip code is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                :label="$t('address')"
                v-model="form.address"
                outlined
                dense
                :rules="[v => !!v || 'Address is required']"
              ></v-text-field>
            </v-col>
          </v-row>
            </v-form>
        </v-container>
        <small>{{ $t("indicates_required_field") }}</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closedialog">
          {{ $t("close") }}
        </v-btn>
        <v-btn color="blue darken-1" text @click="submitForm">
          {{ $t("save") }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  head: {
    title: "",
  },
  components: {},
  data() {
    return {
      valid:false,
      form: {
        name: "",
        type:"customer",
        email:"",
        mobile: "",
        address: "",
        city: "",
        state: "",
        zip_code: "",
        tax_number:"",
        country:"",
      },
    };
  },
  computed: {
    dialog() {
      return this.$store.getters.modaltype == "add"
        ? this.$store.getters.modal
        : false;
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {
    closedialog() {
      this.$store.commit("SET_MODAL", { type: "", status: false });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        await this.$axios.post("/contact", this.form).then((res) => {
          this.$refs.form.reset();
          let data = { alert: true, message: "customer Addedd Successfully",type:'success'};
          this.$store.commit("SET_ALERT", data);
          this.$store.commit("SET_MODAL", false);
          this.$emit("refresh");
        });
      }
    },
  },
};
</script>

<style>
</style>
