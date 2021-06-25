<template>
  <v-dialog v-model="dialog" persistent max-width="600px">
    <v-card>
      <v-card-title>
        {{ $t("add_unit") }}<v-spacer />
        <v-icon aria-label="Close" @click="closedialog"> mdi-close </v-icon>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  outlined
                  dense
                  :label="$t('Unit Name')"
                  required
                  :rules="nameRules"
                  v-model="form.name"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-text-field
                  outlined
                  dense
                  :label="$t('Short Code')"
                  v-model="form.short_code"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-select
                  v-model="form.base_unit"
                  item-text="name"
                  item-value="id"
                  label="Type"
                  dense
                  outlined
                ></v-select>
              </v-col>
              <div
                style="margin-left: 12px; width: 96%"
                v-if="form.base_unit != ''"
              >
                <v-row>
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      outlined
                      dense
                      :label="$t('Operator')"
                      v-model="form.operator"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="6">
                    <v-text-field
                      outlined
                      dense
                      :label="$t('Operation Value')"
                      v-model="form.operation_value"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </div>
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
      nameRules: [(v) => !!v || this.$t("unit_name_is_required")],
      form: {
        name: "",
        short_code: "",
        base_unit: "",
        operator: "",
        operation_value: "",
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
    submitForm() {},
  },
};
</script>

<style>
</style>
