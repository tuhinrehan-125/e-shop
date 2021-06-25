<template>
  <v-container grid-list-sm class="mt-5">
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-card-title>
            Add role
            <v-spacer></v-spacer>
            <v-btn text @click="dialog = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-row no-gutters>
                  <v-col cols="12" sm="12" md="12">
                    <v-text-field
                      outlined
                      dense
                      :label="$t('Role Name')"
                      required
                      :rules="nameRules"
                      v-model="form.name"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-form>
            </v-container>
            <small>{{ $t("indicates_required_field") }}</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              {{ $t("close") }}
            </v-btn>
            <v-btn color="blue darken-1" text @click="submitForm">
              {{ $t("save") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="confirmation" max-width="300" class="pd">
        <v-card class="pd">
          <v-card-title>
            Are you sure?
            <v-spacer />
            <v-icon aria-label="Close" @click="confirmation = false">
              mdi-close
            </v-icon>
          </v-card-title>
          <v-card-text class="pb-6 pt-12 text-center">
            <v-btn class="mr-3" text @click="confirmation = false"> No </v-btn>
            <v-btn color="success" text @click="confirmDelete()"> Yes </v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
    <v-row>
      <v-col>
        <v-btn tile color="indigo" class="float-right" @click="dialog = true">
          <v-icon left> mdi-plus </v-icon>
          {{ $t("Add Role") }}
        </v-btn>
      </v-col>
    </v-row>
    <v-row align="center" justify="center">
      <v-col cols="12" md="6" xl="6" sm="12">
        <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("Roles") }}
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers" :items="roles">
              <template v-slot:item.actions="{ item }">
                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      dark
                      small
                      style="background-color: #6244a6"
                      v-bind="attrs"
                      v-on="on"
                       :to="{
                        name: 'user-role-id-change-permission',
                        params: { id: item.id },
                      }"
                    >
                      <v-icon dark> mdi-shield-lock-outline </v-icon>
                    </v-btn>
                  </template>
                  <span>Change Permission</span>
                </v-tooltip>
                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn small color="error" v-bind="attrs" v-on="on">
                      <v-icon dark> mdi-delete </v-icon>
                    </v-btn>
                  </template>
                  <span>Delete</span>
                </v-tooltip>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "RoleList",
   middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("user.role")) {
      return redirect("/dashboard");
    }
  },
  head: {
    title: "Role List"
  },

  data() {
    return {
      search: "",
      isLoading: false,
      confirmation: false,
      update: false,
      headline: this.$t("Add Role"),
      alert: false,
      valid: true,
      message: "",
      nameRules: [v => !!v || this.$t("Role name is required")],
      dialog: false,
      form: {
        name: ""
      },
      direction: "top right",
      roles: []
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("Roles"),
          value: "name"
        },
        {
          align: "center",
          sortable: false,
          text: this.$t("action"),
          value: "actions"
        }
      ];
    },
    parsedDirection() {
      return this.direction.split(" ");
    }
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getRoles();
  },
  methods: {
    async getRoles() {
      this.isLoading = true;
      await this.$axios.get("/role").then(res => {
        this.roles = res.data.data;
        this.isLoading = false;
      });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        await this.$axios.post("/role", this.form).then(res => {
          let data = {
            alert: true,
            message: "Role Added Successfully",
            type: "success"
          };
          this.$store.commit("SET_ALERT", data);
          this.dialog = false;
          this.getRoles();
        });
      }
    }
  }
};
</script>

<style></style>
