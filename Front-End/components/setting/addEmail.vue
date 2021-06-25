<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <p><b>Mail Driver: </b></p>
          <v-select
            v-model="select"
            :items="[
              'SMTP',
              'Sendmail',
              'Mailgun',
              'Mandrill',
              'SES',
              'Sparkpost',
            ]"
            dense
            outlined
          ></v-select>
        </v-col>

        <v-col cols="12" sm="6" md="4">
          <p><b> Host:</b></p>
          <v-text-field required dense outlined></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b> Port:</b></p>
          <v-text-field required dense outlined></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="6" md="4">
          <p><b>Username: </b></p>
          <v-text-field dense outlined> </v-text-field>
        </v-col>

        <v-col cols="12" sm="6" md="4">
          <p><b> Password:</b></p>
          <v-text-field dense outlined></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b> Encryption:</b></p>
          <v-text-field dense outlined></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="6" md="4">
          <p><b> From Address:</b></p>
          <v-text-field dense outlined></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <p><b> From Name:</b></p>
          <v-text-field dense outlined></v-text-field>
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
      select: "SMTP",
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