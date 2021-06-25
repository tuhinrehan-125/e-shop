<template>
  <v-card>
    <v-card-title>
      Add Expense
    </v-card-title>
    <v-card-text>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row no-gutters>
          <v-col cols="12" md="4" sm="12" xl="4">
            <v-select
              label="Select expense category"
              v-model="form.exp_cat_id"
              :items="exp_category"
              item-text="name"
              item-value="id"
              dense
              :rules="[v => !!v || 'Expense category is required']"
              outlined
            ></v-select>
          </v-col>

          <v-col cols="12" md="4" sm="12" xl="4">
            <v-select
              label="Select business location"
              v-model="form.business_location_id"
              :items="user_business_location"
              item-text="name"
              item-value="id"
              dense
              :rules="[v => !!v || 'Business Location is required']"
              outlined
            ></v-select>
          </v-col>
          <v-col cols="12" md="4" sm="12" xl="4">
            <v-text-field
              :label="$t('expense_for')"
              required
              outlined
              dense
              :rules="[v => !!v || 'Expense for is required']"
              v-model="form.expense_for"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4" sm="12" xl="4">
            <v-text-field
              :label="$t('expense_amount')"
              outlined
              dense
              :rules="[v => !!v || 'Expense amount is required']"
              v-model="form.amount"
            ></v-text-field>
          </v-col>

          <v-col cols="12" md="4" sm="12" xl="4">
            <v-text-field
              :label="$t('ref_no')"
              outlined
              dense
              v-model="form.ref_no"
            ></v-text-field>
          </v-col>

          <v-col cols="12" md="4" sm="12" xl="4">
            <v-dialog
              ref="dialog"
              v-model="modal"
              :return-value.sync="form.exp_date"
              persistent
              width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="form.exp_date"
                  label="Expense date"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  dense
                  outlined
                  :rules="[v => !!v || 'Expense date is required']"
                ></v-text-field>
              </template>
              <v-date-picker v-model="form.exp_date" scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="modal = false">
                  Cancel
                </v-btn>
                <v-btn
                  text
                  color="primary"
                  @click="$refs.dialog.save(form.exp_date)"
                >
                  OK
                </v-btn>
              </v-date-picker>
            </v-dialog>
          </v-col>
          <v-col cols="12" md="4" sm="12" xl="4">
            <v-textarea
              :label="$t('note')"
              required
              outlined
              dense
              v-model="form.note"
            ></v-textarea>
          </v-col>
          <v-col cols="12" md="4" sm="12" xl="4">
            <v-file-input
              label="Upload file"
              v-model="form.file"
            ></v-file-input>
          </v-col>
          <v-col cols="12" md="4" sm="12" xl="4">
            <v-checkbox
              v-model="form.is_monthly_expense"
              :label="$t('This is Monthly Expense')"
              color="info"
              value="info"
              hide-details
            ></v-checkbox>
          </v-col>
          <v-col cols="12">
            <v-btn
              class="float-right"
              color="success"
              @click="submitForm()"
              :loading="isLoading"
              >save</v-btn
            >
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: "addExpense",
  head: {
    title: "Add Expense"
  },
  components: {},
  data() {
    return {
      checkbox: false,
      isLoading: false,
      search: null,
      select: null,
      valid: false,
      modal: false,
      form: {
        exp_cat_id: "",
        business_location_id: "",
        expense_for: "",
        amount: "",
        ref_no: "",
        is_monthly_expense: false,
        exp_date: "",
        note: ""
      },
      exp_category: []
    };
  },
  computed: {
    user_business_location() {
      return this.$auth.user.data.user_business_location;
    }
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getExpenseCategory();
  },
  methods: {
    async getExpenseCategory() {
      await this.$axios.get("/expense-category").then(response => {
        this.exp_category = response.data;
      });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        this.isLoading = true;
        let formData = new FormData();
        for (var key in this.form) {
          formData.append(key, this.form[key]);
        }
        await this.$axios
          .post("expense", formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(res => {
            this.$refs.form.reset();
            this.isLoading = false;
            let data = {
              alert: true,
              message: "Expense Addedd successfully",
              type: "success"
            };
            this.$store.commit("SET_ALERT", data);
            this.$store.commit("SET_MODAL", false);
            this.$emit("refresh");
          });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.v-input--selection-controls.v-input {
  margin-top: 3px;
}

.center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.saveBtn {
  margin-bottom: 5px;
}
</style>
