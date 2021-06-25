<template>
  <v-container>
    <v-card class="mb-70">
      <v-toolbar flat>
        <v-toolbar-title>Business Settings</v-toolbar-title>
      </v-toolbar>
      <v-tabs vertical>
        <v-tab> Business </v-tab>
        <v-tab> Product </v-tab>
        <v-tab> Sale </v-tab>
        <v-tab> Email Settings </v-tab>
        <v-tab> SMS Settings </v-tab>
        <v-tab-item>
          <v-card flat>
            <business-settings :settings="settings" />
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <product-setting />
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <add-sale />
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <add-email />
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <add-sms />
          </v-card>
        </v-tab-item>
      </v-tabs>
    </v-card>
  </v-container>
</template>

<script>
import businessSettings from "@/components/setting/businessSettings";
import addSale from "@/components/setting/addSale";
import addEmail from "@/components/setting/addEmail";
import addSMS from "@/components/setting/addSMS";
import productSetting from "../../components/setting/productSetting";
export default {
  name: "business-settings-page",
  head: {
    title: ""
  },
  components: { businessSettings, productSetting, addSale, addEmail, addSMS },
  data() {
    return {
      settings:{}
    };
  },
  async asyncData({ params, $axios,$auth }) {
    // const { data } = await $axios.get("/business-setting?id=" + $auth.user.data.business_id);
    // const { data } = await $axios.get("/business-setting?id=" + $auth.user.data.business_id);
    // return {
    //   settings: data
    // };
  },
  mounted() {
     this.getBusinessSettings()
    // this.getAllCurrency()
  },
  computed: {
    business_id() {
      return this.$auth.user.data.business_id;
    }
  },
  methods: {
    async getAllCurrency() {
      await this.$axios.get("/get-currency").then(response => {
        this.currencies = response.data.data;
      });
    },
    async getBusinessSettings() {
      await this.$axios
        .get("/business-setting?id=" + this.business_id)
        .then(response => {
          this.settings = response.data;
        });
    },
  }
};
</script>

<style lang="scss" scoped></style>
