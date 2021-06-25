<template>
  <v-container grid-list-sm class="mt-5">
    <v-row justify="center">
      <add-location @refresh="getBusinessLocation()" v-if="add" />
      <v-dialog v-model="confirmation"  max-width="300" class="pd">
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
        <v-btn
          tile
          color="indigo"
          class="float-right"
          @click="opendialog('add')"
        >
          <v-icon left> mdi-plus </v-icon>
          {{ $t("Add Business") }}
        </v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="12">
        <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("All Business") }}
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
            <v-data-table :headers="headers" :items="business_locations">
               <template v-slot:item.actions="{ item }">
              <v-menu open-on-hover top offset-y>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" dark small v-bind="attrs" v-on="on">
                    <v-icon dark> mdi-dots-horizontal </v-icon>
                  </v-btn>
                </template>
                <v-list small>
                  <v-list-item link>
                    <v-list-item-title>
                      <v-icon> mdi-pencil </v-icon>Edit</v-list-item-title
                    >
                  </v-list-item>
                  <v-list-item link @click="deleteBusiness(item)">
                    <v-list-item-title
                      ><v-icon> mdi-delete </v-icon> Delete</v-list-item-title
                    >
                  </v-list-item>
                </v-list>
              </v-menu>
               </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import addLocation from "../../components/locations/addLocation";
export default {
  name: "business_locations",
  head: {
    title: "Business Locations"
  },
  components: { addLocation },
  data() {
    return {
      add: false,
      search: "",
      confirmation: false,
      dialog: false,
      isLoading: false,
      business_locations: []
    };
  },
  computed: {
    business_id() {
      return this.$auth.user.data.business_id;
    },
    headers() {
      return [
        {
          sortable: false,
          text: this.$t("Name"),
          value: "name"
        },
        {
          sortable: false,
          text: this.$t("Mobile"),
          value: "mobile"
        },
        {
          sortable: false,
          text: this.$t("Country"),
          value: "country"
        },
        {
          sortable: false,
          text: this.$t("State"),
          value: "state"
        },
        {
          sortable: false,
          text: this.$t("City"),
          value: "city"
        },
        {
          sortable: false,
          text: this.$t("Zip Code"),
          value: "zip_code"
        },
        {
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
    this.getBusinessLocation();
  },
  methods: {
    async getBusinessLocation() {
      this.isLoading=true
      await this.$axios
        .get("/business-location?id=" + this.business_id)
        .then(response => {
           this.isLoading=false
          this.business_locations = response.data;
        });
    },
    deleteBusiness(item) {},
    opendialog() {
      this.add = true;
      this.$store.commit("SET_MODAL", { type: "add_locations", status: true });
    },

    deleteUnit(item) {
      this.confirmation = true;
      this.catid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`unit/${this.catid}`).then(res => {
        this.alert = true;
        this.message = "Unit Deleted Successfully";
        this.confirmation = false;
        this.getUnits();
      });
    },

    async submitForm() {
      if (this.$refs.form.validate()) {
        if (this.update == false) {
          await this.$axios.post("/unit", this.form).then(res => {
            this.message = "Unit Addedd Successfully";
            this.dialog = false;
            this.alert = true;
            this.getUnits();
          });
        } else {
          await this.$axios.patch(`unit/${this.catid}`, this.form).then(res => {
            this.message = "Unit Updated successfully";
            this.dialog = false;
            this.alert = true;
            this.getUnits();
          });
        }
      }
    }
  }
};
</script>
