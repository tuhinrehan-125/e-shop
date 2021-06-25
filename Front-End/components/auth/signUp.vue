<template>
  <v-container fluid grid-list-sm class="mt-5">
    <v-row align="center" justify="center">
      <v-col cols="12" md="6" lg="6">
        <v-card
         elevation="5"
          class="signup-card d-flex align-content-center flex-wrap mb-70"
        >
          <v-card-title style="margin: 0 auto" class="mb-2">E-Shop | SignUp</v-card-title>
          <v-card-text>
            <v-form
              ref="registerForm"
              method="post"
              v-model="valid"
              lazy-validation
              v-on:submit="validate"
            >

              <v-row no-gutters>
                <v-col cols="12" md="6" lg="6">
                  <v-text-field
                    v-model="form.owner_first_name"
                    :rules="[rules.required]"
                    label="First Name"
                    required
                     outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6" lg="6">
                  <v-text-field
                    v-model="form.owner_last_name"
                    :rules="[rules.required]"
                    label="Last Name"
                    required
                     outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row no-gutters>
                <v-col cols="12" md="6" lg="6">
                  <v-text-field
                    v-model="form.owner_username"
                    :rules="[rules.required]"
                    label="User Name"
                    required
                     outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6" lg="6">
                  <v-text-field
                    v-model="form.business_name"
                    :rules="[rules.required]"
                    label="Business Name"
                    required
                     outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row no-gutters>
                <v-col cols="12">
                  <v-text-field
                    v-model="form.owner_email"
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
                    @click:append="show1 = !show1" >
                  </v-text-field
                  >
                </v-col>

                <v-col cols="12">
                  <v-text-field
                   outlined
                    v-model="form.confirmPassword"
                    :append-icon="show1 ? 'eye' : 'eye-off'"
                    :rules="[rules.required, rules.min, rules.matchPassword]"
                    :type="show1 ? 'text' : 'password'"
                    name="confirmPassword"
                    label="Confirm Password"
                    hint="At least 8 characters"
                    autocomplete="off"
                  >
                    @click:append="show1 = !show1" >
                  </v-text-field
                  >
                </v-col>
                <v-col cols="12">
                  <v-btn
                    block
                    type="submit"
                    :disabled="!valid"
                    color="primary"
                    elevation="7"
                    :loading="isLoading"
                  >
                    SignUp
                  </v-btn>
                </v-col>
                <v-col cols="12">
                   <div class="text-center mb-2">Or have an account? </div>
                   <div class="text-center">
                     <v-btn
                      block
                      color="info"
                      elevation="7"
                      to="/"
                    >
                    Login
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
  name: "signUpComponent",
  data() {
    return {
      isLoading: false,
      dialog: true,
      tab: 0,
      valid: true,
      form: {
        owner_first_name: "",
        owner_last_name: "",
        owner_username: "",
        business_name: "",
        owner_email: "",
        password: "",
        confirmPassword: "",
      },
      verify: "",
      loginPassword: "",
      loginEmail: "",
      loginEmailRules: [
        (v) => !!v || "Required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      emailRules: [
        (v) => !!v || "Required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],

      show1: false,
      rules: {
        required: (value) => !!value || "Required.",
        min: (v) => (v && v.length >= 8) || "Min 8 characters",
        between: (v) => (v) && (v.length >= 2 && v.length <= 100) || "Should between 2 and 100",
        //this method is for password matching
        matchPassword: (value) => {
          return value === this.form.password || 'Password must match'
        }
      },
    };
  },
  methods: {
    async validate(e) {
      e.preventDefault();
      if (this.$refs.registerForm.validate()) {
        try {
          this.isLoading = true;
          await this.$axios.post("auth/signup", this.form);
          this.isLoading = false;
          this.$router.push({ path: '/' });

        } catch (e) {
          this.isLoading = false;
          this.error = e.response.data.message;
        }
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
}
</script>

<style scoped>
.signup-card
{
 margin-top: 10px;
}

.v-application .pa-7 {
  padding: 15px !important;
}

</style>
