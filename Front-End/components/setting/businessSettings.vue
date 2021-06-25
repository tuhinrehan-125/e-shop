<template>
  <v-container>
    <v-form ref="vform" v-model="valid" lazy-validation>
      <v-row>
        <v-col cols="12" sm="6" md="4">
          <v-text-field
            v-model="form.name"
            :counter="10"
            label="Name of business"
            required
            dense
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-select
            v-model="form.currency_id"
            :items="currencies"
            label="Currency"
            item-text="code"
            item-value="id"
            dense
            outlined
          ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-autocomplete
            v-model="form.time_zone"
            :items="timezones"
            label="Time Zone"
            item-text="label"
            item-value="tzCode"
            dense
            outlined
          ></v-autocomplete>
        </v-col>
        <v-col cols="12" sm="6" md="4">
          <v-file-input
            v-model="form.logo"
            label="Upload Logo"
            prepend-icon="mdi-camera"
            dense
            outlined
          ></v-file-input>
        </v-col>
      </v-row>
      <v-btn color="success" class="float-right mb-5" @click="submit"> Update </v-btn>
    </v-form>
  </v-container>
</template>

<script>
import timezones from "timezones-list";

export default {
  props: ['settings'],
  name: "business-setting",
  head: {
    title: ""
  },
  components: {},
  data() {
    return {
      timezones: timezones,
      valid: false,
      form: {},
      currencies: [],
      checkbox: false,
      date: new Date().toISOString().substr(0, 10)
    };
  },
  computed: {
    business_id() {
      return this.$auth.user.data.business_id;
    }
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getAllCurrency();
  },
  methods: {
    async getAllCurrency() {
      await this.$axios.get("/get-currency").then(response => {
        this.currencies = response.data.data;
      });
    },
    async submit() {
      let formData = new FormData();
      for (var key in this.form) {
        formData.append(key, this.form[key]);
      }
      formData.append("_method", "PATCH");
      await this.$axios
        .post(`/business/${this.business_id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log(response);
        });
    }
  },
  watch: {
    settings(val){
     this.form=val
    }
    // 'form.currency_id':function(val){
    //   console.log(val)
    // }
  }
};
</script>

<style></style>
