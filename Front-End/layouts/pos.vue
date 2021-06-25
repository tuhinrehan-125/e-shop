<template>
  <v-app id="main">
    <dashboard-core-drawer temporary="temporary" > </dashboard-core-drawer>
    <nuxt />
    <base-material-snackbar
      v-model="alert"
      :type="type"
      v-bind="{
        [parsedDirection[0]]: true,
        [parsedDirection[1]]: true,
      }"
    >
      {{ message }}
    </base-material-snackbar>
  </v-app>
</template>

<script>
export default {
  head: {
    title: "POS",
  },
  components: {
    DashboardCoreDrawer: () => import("../components/core/Drawer"),
  },

  data() {
    return {
      direction: "top right",
      temporary:true,
    };
  },
  computed: {
    parsedDirection() {
      return this.direction.split(" ");
    },
    alert: {
      get: function () {
        return this.$store.getters.alert;
      },
      set: function (newValue) {},
    },
    type() {
      return this.$store.getters.alertType;
    },
    message() {
      return this.$store.getters.message;
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {},
  methods: {},
  watch: {
    alert(val) {
      if (val == true) {
        setTimeout(() => {
          let data = { alert: false, message: "", type: "success" };
          this.$store.commit("SET_ALERT", data);
        }, 2000);
      }
    },
  },
};
</script>

<style>
#main {
  background: #fff;
  color: rgba(0, 0, 0, 0.87);
  height: 100vh;
}
</style>
