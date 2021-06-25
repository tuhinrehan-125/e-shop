<template>
  <v-dialog v-model="dialog" persistent max-width="600px">
    <v-card>
      <v-card-title>
        Add brand
        <v-spacer></v-spacer>
        <v-btn text @click="closedialog">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row no-gutters>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  outlined
                  dense
                  :label="$t('brand_name')"
                  required
                  :rules="nameRules"
                  v-model="form.name"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-textarea
                  outlined
                  dense
                  color="teal"
                  v-model="form.description"
                >
                  <template v-slot:label>
                    <div>{{ $t("description") }} <small>(optional)</small></div>
                  </template>
                </v-textarea>
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
  name:'AddBrandForm',
  data() {
    return {
      valid: true,
      nameRules: [(v) => !!v || this.$t("brand_name_is_required")],
      form: {
        name: "",
        description: "",
      },
    };
  },
  computed: {
    dialog() {
       return this.$store.getters.modaltype=='add'?this.$store.getters.modal:false;
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
        await this.$axios.post("/brand", this.form).then((res) => {
          this.$refs.form.reset();
          let data = { alert: true, message: "Brand Added Successfully",type:'success' };
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
