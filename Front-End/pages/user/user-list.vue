<template>
  <v-container grid-list-sm>
    <v-row>
      <add-update-user :roles="roles" :userinfo="userinfo" v-if="add" />
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
            <v-btn class="mr-3" text @click="confirmation = false"> No</v-btn>
            <v-btn color="success" text @click="confirmDelete()"> Yes</v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
    <v-row>
      <v-col cols="12" md="12">
        <v-card class="mb-70">
          <v-card-title>
            {{ $t("All Users") }}
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6" xl="4">
                <v-btn depressed tile color="primary" @click="openAddUserModal">
                  <v-icon left> mdi-plus </v-icon>
                  {{ $t("Add User") }}
                </v-btn>
                <!-- <v-btn depressed tile color="warning">
                  <v-icon left> mdi-file-document-outline </v-icon>
                  {{ $t("Import Supplier") }}
                </v-btn> -->
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
                xl="8"
                class="table-export text-right"
              >
                <v-icon class="excel rounded" color="#20AB11">
                  mdi-file-document-outline
                </v-icon>
                <v-icon class="pdf rounded" color="#FF8800">
                  mdi-file-pdf-box
                </v-icon>
                <v-icon class="printer rounded" color="primary">
                  mdi-printer
                </v-icon>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6" md="2" sm="2" xl="2">
                <v-select label="Bulk Action" outlined dense></v-select>
              </v-col>
              <v-col cols="6" md="10" sm="10" xl="10">
                <v-row no-gutters class="filter-section d-flex justify-end">
                  <v-col cols="6" md="2" sm="6" xl="3">
                    <v-text-field
                      v-model="search"
                      @click:append="searchItem"
                      @keyup="searchItem"
                      label="Search"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <div class="datatable">
              <v-skeleton-loader
                v-if="isLoading"
                type="table"
              ></v-skeleton-loader>
              <v-data-table
                v-else
                :headers="headers"
                :items="users"
                show-select
              >
                <template v-slot:item.actions="{ item }">
                  <v-icon @click="openEditUserModal(item)">
                    mdi-square-edit-outline
                  </v-icon>
                  <v-icon> mdi-trash-can-outline </v-icon>
                </template>
              </v-data-table>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import addUpdateUser from "../../components/user/addUpdateUser.vue";
export default {
  middleware({ $gates, redirect }) {
    if (!$gates.hasPermission("user.view")) {
      return redirect("/dashboard");
    }
  },
  name: "UserList",
  head: {
    title: "User List",
  },
  components: { addUpdateUser },
  data() {
    return {
      add: false,
      userinfo: {},
      search: "",
      isLoading: false,
      roles: [],
      users: [],
      confirmation: false,
    };
  },
  computed: {
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("Username"),
          value: "username",
        },
        {
          sortable: false,
          text: this.$t("First Name"),
          value: "first_name",
        },
        {
          sortable: false,
          text: this.$t("Last Name"),
          value: "last_name",
        },
        {
          sortable: false,
          text: this.$t("Email"),
          value: "email",
        },
        {
          sortable: false,
          text: this.$t("Role"),
          value: "roles",
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
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
    this.getRoles();
  },
  methods: {
    searchItem() {},
    async getRoles() {
      this.isLoading = true;
      await this.$axios.get("/role").then((response) => {
        this.roles = response.data.data;
        this.isLoading = false;
      });
    },
    async getUsers() {
      this.isLoading = true;
      await this.$axios.get("/users").then((response) => {
        this.users = response.data;
        this.isLoading = false;
      });
    },
    openAddUserModal() {
      this.add = true;
      this.$store.commit("SET_MODAL", { type: "addUser", status: true });
    },
    openEditUserModal(user) {
      this.userinfo = user;
      this.add = true;
      this.$store.commit("SET_MODAL", { type: "addUser", status: true });
    },
  },
};
</script>
