<template>
  <v-dialog v-model="dialog" persistent max-width="600px">
    <v-card>
      <v-card-title>
        {{ $t("view_Payment") }}<v-spacer />
        <v-icon aria-label="Close" @click="closedialog"> mdi-close </v-icon>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row no-gutters>
            <v-col cols="12">
              <v-data-table :headers="headers" :items="data" ></v-data-table>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: ["data"],
  name: "viewPayment",
  data() {
    return {};
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("payment_amount"),
          value: "payment_amount"
        },
        {
          sortable: false,
          text: this.$t("payment_method"),
          value: "payment_method"
        },
        {
          sortable: false,
          text: this.$t("Date"),
          value: "payment_date"
        }
      ];
    },
    dialog() {
      return this.$store.getters.modaltype == "viewpayment"
        ? this.$store.getters.modal
        : false;
    },
    modaltype() {
      return this.$store.getters.modaltype;
    }
  },
  mounted() {},
  methods: {
    closedialog() {
      this.$store.commit("SET_MODAL", { type: "", status: false });
    }
  },
  watch: {}
};
</script>

<style scoped></style>
