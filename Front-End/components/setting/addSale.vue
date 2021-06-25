<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <p><b> Default Sale Discount:*</b></p>
          <v-text-field required dense outlined></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b>Default Sale Tax: </b></p>
          <v-select
            v-model="select"
            :items="['Default sale tax', 'None', 'Ac']"
            dense
            outlined
          ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b>Sale Commision Agent: </b></p>
          <v-select
            v-model="select2"
            :items="['Disable', 'Loged in user', 'Select from users list']"
            dense
            outlined
          ></v-select>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="6" md="4">
          <p><b>Sales Item Addition Method: </b></p>
          <v-select
            v-model="select3"
            :items="[
              'Add item in new row',
              'Increase item quantity if it already exists',
            ]"
            dense
            outlined
          ></v-select>
        </v-col>
        <v-col cols="12" sm="1" md="4">
          <v-checkbox
            style="padding-top: 25px"
            v-model="ex4"
            label="Sales price is minimum selling price"
            color="primary"
            value="primary"
            hide-details
          ></v-checkbox>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-checkbox style="padding-top: 25px" v-model="checkbox">
            <template v-slot:label>
              <div><b> Allow Overselling</b></div>
            </template>
          </v-checkbox>
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
      select: "None",
      select2: "Disable",
      select3: "Increase item quantity if it already exists",
    };
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {},
};
</script>

<style>
</style>