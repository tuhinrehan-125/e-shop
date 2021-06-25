<template>
  <v-main>
   <breadcrumbs />
    <router-view />
    <base-material-snackbar
      v-model="alert"
      :type="type"
      v-bind="{
        [parsedDirection[0]]: true,
        [parsedDirection[1]]: true
      }"
    >
      {{ message }}
    </base-material-snackbar>
    <dashboard-core-footer />
  </v-main>
</template>

<script>
export default {
  name: "DashboardCoreView",

  components: {
    DashboardCoreFooter: () => import("./Footer"),
    breadcrumbs:() => import("./../app/breadcrumbs")
  },
  data() {
    return {
      direction: "top right"
    };
  },
  computed: {
    parsedDirection() {
      return this.direction.split(" ");
    },
    alert: {
      get: function() {
        return this.$store.getters.alert;
      },
      set: function(newValue) {}
    },
    type() {
      return this.$store.getters.alertType;
    },
    message() {
      return this.$store.getters.message;
    }
  },
  watch: {
    alert(val) {
      if (val == true) {
        var self = this;
        setTimeout(() => {
          let data = { alert: false, message: "", type: "success" };
          self.$store.commit("SET_ALERT", data);
        }, 5000);
      }
    }
  }
};
</script>
<style scoped>
.v-sheet.v-card
{
  border-radius: 0px;
  height: 80px;
  max-height: 100px;
}
</style>
