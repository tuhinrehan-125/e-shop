<template>
  <v-dialog v-model="dialog" persistent max-width="800px">
    <v-card>
      <v-card-title>
        Add supplier
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
                :label="$t('supplier_name')"
                required
                outlined
                dense
                v-model="form.name"
                :rules="[v => !!v || 'Supplier name is required']"
              ></v-text-field>
            </v-col>
            <v-col  cols="12" md="6" >
              <v-text-field
                :label="$t('supplier_business_name')"
                outlined
                dense
                v-model="form.supplier_business_name"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('email')"
                v-model="form.email"
                outlined
                dense
                :rules="[v => !!v || 'Email is required']"
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
                :rules="[v => !!v || 'country is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('city')"
                v-model="form.city"
                outlined
                dense
                :rules="[v => !!v || 'city is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('state')"
                v-model="form.state"
                outlined
                dense
                :rules="[v => !!v || 'state required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :label="$t('zip_code')"
                v-model="form.zip_code"
                outlined
                dense
                :rules="[v => !!v || 'zip_code is required']"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                :label="$t('address')"
                v-model="form.address"
                outlined
                dense
                :rules="[v => !!v || 'address No is required']"
              ></v-text-field>
            </v-col>
<!--
            <v-col cols="6">
              <v-text-field
                :label="$t('nid_no')"
                required
                outlined
                dense
                type="number"
                v-model="form.nid_no"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field
                :label="$t('commission_rate')"
                outlined
                dense
                v-model="form.commission_rate"
              ></v-text-field>
            </v-col> -->
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
        supplier_business_name:"",
        type:"supplier",
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
          let data = { alert: true, message: "Supplier Addedd Successfully",type:'success' };
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
