<template>
  <v-dialog v-model="dialog" persistent max-width="800px">
    <v-card>
      <v-card-title>
        Edit customer<v-spacer />
        <v-icon aria-label="Close" @click="closedialog"> mdi-close </v-icon>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row no-gutters>
              <v-col cols="12" md="6">
                <v-text-field
                  class="smalltext"
                  :label="$t('customer_name')"
                  required
                  outlined
                  dense
                  v-model="form.name"
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
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  :label="$t('country')"
                  v-model="form.country"
                  outlined
                  dense
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  :label="$t('city')"
                  v-model="form.city"
                  outlined
                  dense
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  :label="$t('state')"
                  v-model="form.state"
                  outlined
                  dense
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  :label="$t('zip_code')"
                  v-model="form.zip_code"
                  outlined
                  dense
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  :label="$t('address')"
                  v-model="form.address"
                  outlined
                  dense
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
  props: ["item"],
  head: {
    title: "",
  },
  components: {},
  data() {
    return {
      valid:false,
      form: {},
    };
  },
  computed: {
    dialog() {
      return this.$store.getters.modaltype == "edit"
        ? this.$store.getters.modal
        : false;
    },
    modaltype() {
      return this.$store.getters.modaltype;
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
        await this.$axios
          .patch(`contact/${this.form.id}`, this.form)
          .then((res) => {
            this.$refs.form.reset();
            let data = {
              alert: true,
              message: "customer updated Successfully",
            };
            this.$store.commit("SET_ALERT", data);
            this.$store.commit("SET_MODAL", false);
            this.$emit("refresh");
          });
      }
    },
  },
  watch: {
    item(val) {
      this.form = val;
    },
  },
};
</script>

<style>
</style>
