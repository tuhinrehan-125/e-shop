<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row>
        <v-col cols="12" sm="6" md="6">
          <p><b>Gateway:* </b></p>
          <v-select
            :items="['gateway 1', 'gateway 2']"
            label="Select SMS Gatway"
            dense
            outlined
          ></v-select>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="6" md="4">
          <p><b> Account SID:*</b></p>
          <v-text-field required dense outlined></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b> Auth Token:*</b></p>
          <v-text-field required dense outlined></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b> Gateway Number:*</b></p>
          <v-text-field required dense outlined></v-text-field>
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
    return {};
  },
  computed: {},
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {},
};
</script>

<style>
</style>