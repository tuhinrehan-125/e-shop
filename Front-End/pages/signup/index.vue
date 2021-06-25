<template>
  <v-app id="register">
    <sign-up></sign-up>
  </v-app>
</template>

<script>
import signUp from "~/components/auth/signUp";
export default {
  name: "SignUp",
  layout: "register",
  auth: false,
  head: {
    title: "Signup",
  },

  components: {
    signUp
  }
};
</script>

