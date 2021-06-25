<template>
  <v-container grid-list-sm >
    <add-product :data="data" />
  </v-container>
</template>
<script>
import addProduct from "../../../components/product/addProduct";
export default {
  name: "editProductPage",
  components: { addProduct },
  data() {
    return {

    };
  },
  computed: {

  },
  mounted() {

  },

    async asyncData({ params, $axios }) {
    const { data } = await $axios.get(
      `product/${params.id}`
    );
    return {
      data:data.data
    };
  },
  methods: {

  }
};
</script>

<style scoped></style>
