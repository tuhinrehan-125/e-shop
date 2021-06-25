<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <v-text-field required dense outlined></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b>Enable Product Expiry: </b></p>
          <v-row style="margin-top: 10px">
            <v-checkbox
              v-model="enabled"
              hide-details
              class="shrink mr-2 mt-0"
            ></v-checkbox>
            <v-select
              :disabled="!enabled"
              v-model="select3"
              :items="[
                'Add item expiry',
                'Add item expiry if it already exists',
              ]"
              label="Add item expiry"
              dense
              outlined
            ></v-select>
          </v-row>
        </v-col>

        <v-col cols="12" sm="6" md="4" v-show="enabled">
          <p>On Product Expiry:</p>
          <v-select
            v-model="select2"
            :items="['Keep Selling', 'Stop Selling n Days Before']"
            dense
            outlined
          ></v-select>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="6" md="4">
          <v-list-item>
            <v-list-item-action>
              <v-checkbox :input-value="active" color="primary"></v-checkbox>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>Enable Brands</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-list-item>
            <v-list-item-action>
              <v-checkbox
                :input-value="active"
                color="primary"
                v-model="category"
              ></v-checkbox>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>Enable Categories</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-col>
        <v-col cols="12" sm="6" md="4" v-show="category">
          <v-list-item>
            <v-list-item-action>
              <v-checkbox :input-value="active" color="primary"></v-checkbox>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>Enable Sub-Categories</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="6" md="4">
          <v-list-item>
            <v-list-item-action>
              <v-checkbox :input-value="active" color="primary"></v-checkbox>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>Enable Price & Tax Info</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <p><b>Default Unit: </b></p>
          <v-select
            v-model="select"
            :items="['Kilogram', 'Meter', 'Kilometer']"
            dense
            outlined
          ></v-select>
        </v-col>
      </v-row>

      <v-btn color="success" class="mr-4"> Update </v-btn>
    </v-form>
  </v-container>
</template>

<script>
export default {
  head: {
    title: "",
  },
  components: {},
  data() {
    return {
      includeFiles: true,
      enabled: false,

      category: false,

      select: "Kilogram",
      select2: "Keep Selling",
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {},
};
</script>

<style scoped lang="scss">
.v-application--is-ltr .v-list-item__action:first-child,
.v-application--is-ltr .v-list-item__icon:first-child {
  margin-right: 12px;
}
</style>