<template>
  <v-container class="v-centered">
    <h3 class="text-center mt-20">Welcome to E-Shop</h3>
    <v-row align="center" justify="center">
      <v-col cols="12" md="5" lg="5">
        <v-card
          elevation="5"
          class="login-card d-flex align-content-center flex-wrap "
        >
          <v-card-title style="margin: 0 auto" class="mb-2"
            >E-Shop | Login</v-card-title
          >
          <v-card-text>
            <v-form
              ref="loginForm"
              method="post"
              v-model="valid"
              lazy-validation
              v-on:submit="validate"
            >
              <v-row no-gutters>
                <v-col cols="12">
                  <v-text-field
                    v-model="form.email"
                    :rules="loginEmailRules"
                    label="E-mail"
                    required
                    outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    outlined
                    v-model="form.password"
                    :append-icon="show1 ? 'eye' : 'eye-off'"
                    :rules="[rules.required, rules.min]"
                    :type="show1 ? 'text' : 'password'"
                    name="input-10-1"
                    label="Password"
                    hint="At least 8 characters"
                    autocomplete="off"
                  >
                    @click:append="show1 = !show1" ></v-text-field
                  >
                </v-col>
                <v-col class="d-flex" cols="12" sm="6" xsm="12" v-if="error">
                  <p class="danger">{{ error }}</p>
                </v-col>
                <v-col cols="12">
                  <v-btn
                    block
                    large
                    type="submit"
                    :disabled="!valid"
                    color="primary"
                    elevation="7"
                    :loading="isLoading"
                  >
                    Login
                  </v-btn>
                </v-col>
                <v-col cols="12">
                  <div class="text-center mb-2">OR</div>
                  <div class="text-center">
                    <v-btn block color="info" elevation="7" to="/signup">
                      SignUp
                    </v-btn>
                  </div>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Login",
  layout: "login",
  middleware: "guest",
  head: {
    title: "Login"
  },
  data() {
    return {
      isLoading: false,
      valid: true,
      error: null,
      form: {
        email: "",
        password: ""
      },
      loginEmailRules: [
        v => !!v || "Required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      show1: false,
      rules: {
        required: value => !!value || "Required.",
        min: v => (v && v.length >= 8) || "Min 8 characters"
      }
    };
  },
  methods: {
    async validate(e) {
      e.preventDefault();
      this.error = null;
      if (this.$refs.loginForm.validate()) {
        try {
          this.isLoading = true;
          let response = await this.$auth.loginWith("local", {
            data: this.form
          });
          this.$gates.setRoles(response.data.role);
          this.$gates.setPermissions(response.data.permissions);
          if (response.data.role == "admin") {
            if (response.data.user_business_location.length == 0) {
              this.$router.push("/business-setting-and-location");
            } else {
              this.$router.push("/dashboard");
            }
          } else {
            this.$router.push("/dashboard");
          }
          this.isLoading = false;
        } catch (e) {
          this.isLoading = false;
          if (e.response.status == 401) {
            this.error = "Wrong email or password !";
          }
        }
      }
    },

    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    }
  },

  computed: {
    passwordMatch() {
      return () => this.password === this.verify || "Password must match";
    }
  }
};
</script>
<style scoped>
.mt-20 {
  margin-top: 20px;
}
.login-card {
  margin-top: 50px;
}
.v-application .pa-7 {
  padding: 15px !important;
}
.danger {
  color: red;
}
</style>
