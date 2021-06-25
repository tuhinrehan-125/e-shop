<template>
  <v-dialog v-model="dialog" persistent max-width="600px">
    <v-card>
      <v-card-title>
        {{ $t("add_category") }}<v-spacer />
        <v-icon aria-label="Close" @click="closedialog"> mdi-close </v-icon>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row no-gutters>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  outlined
                  dense
                  :label="$t('category_name')"
                  required
                  :rules="nameRules"
                  v-model="form.name"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-select
                  v-model="form.parent_id"
                  :items="items"
                  :label="$t('parent_category')"
                  item-text="name"
                  item-value="id"
                  dense
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  outlined
                  dense
                  :label="$t('short_code')"
                  required
                  v-model="form.short_code"
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
  props: ["items"],
  data() {
    return {
      valid: true,
      nameRules: [(v) => !!v || this.$t("catname_is_required")],
      form: {
        name: "",
        parent_id: "",
        short_code: "",
      },
    };
  },
  computed: {
    dialog() {
        return this.$store.getters.modaltype=='add'?this.$store.getters.modal:false;
    },
    modaltype(){
      return this.$store.getters.modaltype
    }
  },
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {
    closedialog() {
      this.$store.commit("SET_MODAL", {type:'',status:false});
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        await this.$axios.post("/category", this.form).then((res) => {
          this.$refs.form.reset();
          let data = { alert: true, message: "Category Addedd Successfully",type:'success'};
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
