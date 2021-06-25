<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        Invoice No:
        <strong>{{ invoiceno }}</strong>
        <span class="float-right"> <strong>Status:</strong> Pending/Success</span>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-sm-6">
            <h6 class="mb-3">From:</h6>
            <div>
              <strong>Webz Poland</strong>
            </div>
            <div>Madalinskiego 8</div>
            <div>71-101 Szczecin, Poland</div>
            <div>Email: info@webz.com.pl</div>
            <div>Phone: +48 444 666 3333</div>
          </div>

          <div class="col-sm-6" v-if="client">
            <h6 class="mb-3">To:</h6>
            <div>
              <strong>{{ client.name }}</strong>
            </div>
            <div>Compnay Name: {{ client.company_name }}</div>
            <div>Address: {{ client.address }}</div>
            <div>Phone: {{ client.mobile_no }}</div>
          </div>
        </div>

        <div class="table-responsive-sm">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="center">#</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Customer</th>
                <th>Payment Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product, index) in products" :key="index">
                <td class="center">{{ index + 1 }}</td>
                <td class="left strong">{{ product.product }}</td>
                <td class="left">{{ product.price }}</td>
                <td class="right" v-if="product.qtymethod=='Thika'">{{ product.qtymethod }}</td>
                <td class="right" v-else>{{ product.qty }} {{ product.qtymethod }}</td>
                <td class="center">{{ product.total }}</td>
                <td class="center">{{ product.customer_name }}</td>
                <td class="right">{{ product.ptype }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-lg-4 col-sm-5"></div>

          <div class="col-lg-4 col-sm-5 ml-auto">
            <table class="table table-clear">
              <tbody>
                <tr>
                  <td class="left">
                    <strong>Subtotal :</strong>
                  </td>
                  <td class="right">{{ subTotalPrice }}</td>
                </tr>
                <tr>
                  <td class="left">
                    <strong>Discount ({{ commission }})% :</strong>
                  </td>
                  <td class="right">{{ totalPrice }}</td>
                </tr>
                <tr v-if="advance_payout">
                  <td class="left">
                    <strong>Advance Payout :</strong>
                  </td>
                  <td class="right">{{ advance_payout }}</td>
                </tr>
                <tr>
                  <td class="left">
                    <strong>Total :</strong>
                  </td>
                  <td class="right">
                    <strong>{{ grandTotal }}</strong>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  layout: "login",
  head: {
    title: "",
  },
  components: {},
  props: [
    "client",
    "invoiceno",
    "products",
    "subTotalPrice",
    "commission",
    "totalPrice",
    "grandTotal",
    "advance_payout"
  ],
  data() {
    return {
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
