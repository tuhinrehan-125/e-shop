<template>
  <v-container fluid>
    <v-row justify="center">
      <base-material-snackbar
        v-model="alert"
        type="success"
        v-bind="{
          [parsedDirection[0]]: true,
          [parsedDirection[1]]: true,
        }"
      >
        {{ message }}
      </base-material-snackbar>

      <v-col cols="12" sm="12" md="12">
        <v-card>
          <v-card-title>
            {{ $t("User Profile") }}
          </v-card-title>
          <v-card-text>
            <v-row no-gutters justify="center">
              <v-col cols="12" md="10">
                <v-form>
                  <v-container class="py-0">
                    <v-row>

                      <v-col cols="12" sm="6" md="6">
                        <v-text-field
                          :label="$t('First Name')"
                          v-model="form.first_name"
                        ></v-text-field>
                      </v-col>


                      <v-col cols="12" sm="6" md="6">
                        <v-text-field
                          :label="$t('Last Name')"
                          v-model="form.last_name"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12" md="6">
                        <v-text-field
                          :label="$t('email')"
                          required
                          v-model="form.email"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="12">
                        <v-card max-width="50%">
                          <v-card-actions>
                            <v-btn
                              text
                              color="teal accent-4"
                              @click="reveal = true"
                            >
                              {{ $t("change_password") }}
                            </v-btn>
                          </v-card-actions>
                          <v-expand-transition>
                            <v-card
                              v-if="reveal"
                              class="transition-fast-in-fast-out v-card--reveal"
                              style="height: 100%"
                            >
                              <v-card-text class="pt-0" style="display: flex">
                                <v-text-field></v-text-field>
                                <v-card-actions>
                                  <v-btn
                                    text
                                    color="teal accent-4"
                                    @click="reveal = false"
                                  >
                                    {{ $t("close") }}
                                  </v-btn>
                                </v-card-actions>
                              </v-card-text>
                            </v-card>
                          </v-expand-transition>
                        </v-card>
                      </v-col>

                      <v-col cols="12" class="text-right">
                        <v-btn
                          color="primary"
                          min-width="150"
                          @click="updateUser"
                        >
                          Update Profile
                        </v-btn>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-form>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "userProfile",
  middleware: "auth",
  head: {
    title: "User Profile",
  },
  components: {},
  data: () => ({
    loading: false,
    selection: 1,
    reveal: false,

    alert: false,
    dialog: false,
    confirmation: false,
    message: "",

    form: {
      first_name: "",
      last_name: "",
      email: "",
    },
    direction: "top right",
    users: [],
  }),
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("first_name"),
          value: "first_name",
        },
        {
          sortable: false,
          text: this.$t("last_name"),
          value: "last_name",
        },

        {
          sortable: false,
          text: this.$t("email_address"),
          value: "email",
        },
        {
          sortable: false,
          text: this.$t("password"),
          value: "password",
        },
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getUsers();
  },
  methods: {
    reserve() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);
    },

    async getUsers() {
      await this.$axios.get("/auth/userinfo").then((response) => {
        this.form = response.data.data;
      });
    },
    async updateUser() {
      console.log(this.form);
      await this.$axios.patch(`user/${this.form.id}`, this.form).then((res) => {
        this.message = "User Updated successfully";
        this.dialog = false;
        this.alert = true;
        this.getUsers();
      });
    },
  },
};
</script>

<style scoped>
::v-deep .v-application--is-ltr .v-text-field__suffix {
  background-color: rgb(12, 113, 138);
  cursor: pointer;
  width: 115px;
  height: 30px;
  padding: 5px;
  color: white;
  border-radius: 5px;
  padding-left: 8px;
}

::v-deep .v-card--reveal {
  bottom: -15px;
  opacity: 1 !important;
  position: absolute;
  width: 100%;
}

::v-deep .v-card > .v-card__progress + :not(.v-btn):not(.v-chip),
.v-card > :first-child:not(.v-btn):not(.v-chip) {
  margin-top: -6px;
  width: 100%;
}

::v-deep .v-input input:active,
.v-input input,
.v-input textarea:active,
.v-input textarea {
  width: 500px;
}
::v-deep
  .v-sheet
  button.v-btn.v-size--default:not(.v-btn--icon):not(.v-btn--fab) {
  margin-left: 20px;
}
</style>
