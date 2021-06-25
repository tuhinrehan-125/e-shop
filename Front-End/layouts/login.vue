<template>
  <v-app id="main">
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
    title: "",
  },
  components: {},
  data() {
    return {
      direction: "top right",
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
  mounted() {
    setTimeout(() => {
      let data = { alert: false, message: "", type: "success" };
      this.$store.commit("SET_ALERT", data);
    }, 1000);
  },
  methods: {},
  watch: {
    alert(val) {
      if (val == true) {
        setTimeout(() => {
          let data = { alert: false, message: "", type: "success" };
          this.$store.commit("SET_ALERT", data);
        }, 1000);
      }
    },
  },
};
</script>

<style>
#main {
  background: #f2f5f8;
  color: rgba(0, 0, 0, 0.87);
  height: 100vh;
}
</style>
