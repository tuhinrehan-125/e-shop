<template>
  <v-dialog v-model="dialog" persistent max-width="600px">
    <v-card>
      <v-card-title>
        {{ $t("add_Payment") }}<v-spacer />
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
                  :label="$t('due_amount')"
                  required
                  :rules="paymentamountRules"
                  v-model="form.payment_amount"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-select
                  label="Select payment method"
                  v-model="form.payment_method"
                  :items="methods"
                  item-text="name"
                  item-value="id"
                  dense
                  outlined
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="12">
                <v-textarea
                  rows="2"
                  label="Payment Note"
                  outlined
                  dense
                  required
                  v-model="form.payment_note"
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row no-gutters>
              <v-col cols="12">
                <v-btn
                  class="float-right"
                  dark
                  color="success"
                  :loading="isLoading"
                  @click="submitForm"
                >
                  Submit
                </v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: ["item", "type"],
  name: "addPayment",
  data() {
    return {
      isLoading: false,
      valid: true,
      paymentamountRules: [
        v => !!v || "Payment amount is required",
        v =>
          v <= this.item.total_due ||
          "Paying Amount must be less than due amount"
      ],
      form: {
        payment_amount: "",
        payment_method: "Cash",
        payment_note: ""
      },
      methods: ["Cash", "Card", "Bank Transfer"]
    };
  },
  computed: {
    dialog() {
      return this.$store.getters.modaltype == "addpayment"
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
    },
    async submitForm() {
      if (this.type == "purchase") {
        if (this.$refs.form.validate()) {
          this.isLoading = true;
          await this.$axios
            .patch(`purchase/addpayment/${this.item.id}`, this.form)
            .then(res => {
              this.isLoading = false;
              this.$refs.form.reset();
              let data = {
                alert: true,
                message: "Payment Added Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", false);
              this.$emit("refresh");
            });
        }
      } else if (this.type == "sell") {
        if (this.$refs.form.validate()) {
          this.isLoading = true;
          await this.$axios
            .patch(`sell/addpayment/${this.item.id}`, this.form)
            .then(res => {
              this.isLoading = false;
              this.$refs.form.reset();
              let data = {
                alert: true,
                message: "Payment Added Successfully",
                type: "success"
              };
              this.$store.commit("SET_ALERT", data);
              this.$store.commit("SET_MODAL", false);
              this.$emit("refresh");
            });
        }
      }
    }
  },
  watch: {
    item(val) {
      this.form.payment_amount = val.total_due;
    }
  }
};
</script>

<style scoped></style>
