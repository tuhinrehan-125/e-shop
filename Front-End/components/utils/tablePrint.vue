<template>
  <table style="width: 750px; border-collapse: collapse; margin: 50px auto">
    <thead>
      <tr>
        <th v-for="header,i in headers" :key="i" v-show="header.text!=='Action'"
          style="
            background: #3498db;
            color:#fff;
            font-weight: bold;
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
        <span>
          {{header.text}}
        </span>

        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item,i in data" :key="i">
        <td
          style="
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
        <img :src="item.image" :alt="item.name" style="width:50px; height:auto;">

        </td>
        <td
          style="
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
           {{item.name}}
        </td>
        <td
          style="
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
           {{item.sku}}
        </td>
        <td
          style="
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
           {{item.category}}
        </td>
        <td
          style="
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
           {{item.unit_name}}
        </td>
        <td
          style="
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
           {{item.purchase_price}}
        </td>
        <td
          style="
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
          "
        >
           {{item.sell_price}}
        </td>

      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props:['headers','data'],
  head: {
    title: "",
  },
  components: {},
  data() {
    return {};
  },
  computed: {

  },
  async asyncData({ params, axios }) {},
  mounted() {

  },
  methods: {},
};
</script>

<style lang="scss" scoped>
</style>
