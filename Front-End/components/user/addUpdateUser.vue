<template>
  <v-dialog v-model="dialog" persistent max-width="800px">
    <v-card>
      <v-card-title>
        {{ $t("Add User") }}
        <v-spacer />
        <v-btn white text @click="closedialog">
          <v-icon aria-label="Close">mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-form ref="abc" v-model="valid" lazy-validation>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  outlined
                  dense
                  :label="$t('Mr/Mrs/Miss')"
                  required
                  v-model="form.surname"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  outlined
                  dense
                  :label="$t('First Name')"
                  required
                  :rules="fnameRules"
                  v-model="form.first_name"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  outlined
                  dense
                  :label="$t('Last Name')"
                  required
                  :rules="lnameRules"
                  v-model="form.last_name"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  outlined
                  dense
                  :label="$t('Email')"
                  :rules="emailRules"
                  v-model="form.email"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  outlined
                  dense
                  item-text="name"
                  item-value="id"
                  :items="roles"
                  :label="$t('Role')"
                  v-model="form.role"
                  :rules="roleRules"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  outlined
                  dense
                  multiple
                  item-text="name"
                  item-value="id"
                  :items="business_locations"
                  :label="$t('Location')"
                  v-model="form.location_id"
                  :rules="roleRules"
                ></v-select>
              </v-col>
              
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  outlined
                  dense
                  :label="$t('Username')"
                  v-model="form.username"
                  :rules="usernameRules"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  outlined
                  dense
                  :rules="[passwordRules.required, passwordRules.min]"
                  :label="$t('Password')"
                  v-model="form.password"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-form>
        </v-container>
        <!--            <small>{{ $t("indicates_required_field") }}</small>-->
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
  props: ["roles", "userinfo"],
  name: "addUpdateUser",
  data() {
    return {
      valid: false,
      isLoading: false,
      message: "",
      fnameRules: [v => !!v || this.$t("This field is required")],
      lnameRules: [v => !!v || this.$t("This field is required")],
      usernameRules: [v => !!v || this.$t("This field is required")],
      emailRules: [
        v => !!v || "Required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      roleRules: [v => !!v || this.$t("This field is required")],
      passwordRules: {
        required: value => !!value || "Required.",
        min: v => (v && v.length >= 8) || "Min 8 characters"
      },
      form: {
        surname: "",
        first_name: "",
        last_name: "",
        username: "",
        email: "",
        password: "",
        role: "",
        location_id:[]
      }
    };
  },
  computed: {
    dialog() {
      return this.$store.getters.modaltype == "addUser"
        ? this.$store.getters.modal
        : false;
    },
     business_locations() {
      return this.$auth.user.data.user_business_location;
    },
  },
  mounted() {
    if (Object.keys(this.userinfo).length) {
      this.form = this.userinfo;
      this.form.role = this.userinfo.roles[0]; 
    }
  },
  methods: {
    closedialog() {
      this.$store.commit("SET_MODAL", { type: "", status: false });
    },
    async submitForm() {
      if (this.$refs.abc.validate()) {
        await this.$axios.post("/create-user", this.form).then(res => {
          this.$refs.abc.reset();
          let data = {
            alert: true,
            message: "User Created Successfully",
            type: "success"
          };
          this.$store.commit("SET_ALERT", data);
          this.$store.commit("SET_MODAL", false);
        });
      }
    }
  },
  watch: {
    userinfo(val){
      this.form = val;
      this.form.role = val.roles[0];
      this.$refs.abc.reset();
    } 

  }
};
</script>

<style scoped></style>

