<template>
  <v-container id="dashboard" class="mb-60" fluid tag="section" grid-list-xl>
    <v-row class="mt-2 top-card">
      <!-- <v-col cols="12" sm="3" md="3">
        <v-card flat class="store-card">
          <v-card-text class="pl-8 pt-6">
            <img src="~/assets/image/001-store.svg" />
            <p class="body-1">
              Total Store
            </p>
            <p class="counter">
              10
            </p>
            <p class="details">
              Details
            </p>
          </v-card-text>
        </v-card>
      </v-col> -->
      <v-col cols="12" sm="3" md="3">
        <v-card flat class="revenue-card" >
          <v-card-text class="pl-8 pt-6">
            <img src="~/assets/image/002-increased-revenue.svg" />
            <p class="body-1 mt-2">
              Revenue
            </p>
            <p class="counter">
              $16,5666
            </p>
            <p class="details">
              Details
            </p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="3" md="3">
        <v-card flat class="expense-card">
          <v-card-text class="pl-8 pt-6">
            <img src="~/assets/image/003-medical.svg" />
            <p class="body-1 mt-2">
              Expenses
            </p>
            <p class="counter">
              $10,00
            </p>
            <p class="details">
              Details
            </p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="3" md="3">
        <v-card flat class="commission-card">
          <v-card-text class="pl-8 pt-6">
            <img src="~/assets/image/004-commission.svg" />
            <p class="body-1 mt-2">
              Commissions
            </p>
            <p class="counter">
              $950
            </p>
            <p class="details">
              Details
            </p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="3" md="3">
        <v-card flat class="profits-card">
          <v-card-text class="pl-8 pt-6">
            <img src="~/assets/image/005-profits.svg" />
            <p class="body-1 mt-2">
              Profits
            </p>
            <p class="counter">
              $6,540
            </p>
            <p class="details">
              Details
            </p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="6" md="8">
        <v-card flat>
          <v-card-text class="pl-8 pt-6">
            <apexchart
              type="line"
              height="300"
              max-width="650"
              :options="lineOptions"
              :series="lineseries"
            ></apexchart>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-card flat >
          <v-card-text class="pl-8 pt-6">
            <apexchart
              type="pie"
              height="320"
              :options="chartOptions"
              :series="piedata"
            ></apexchart>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" sm="8" md="8">
        <v-card flat>
          <v-card-title style="font-size:16px;"
            >Recent Transactions</v-card-title
          >
          <v-card-text>
            <v-tabs >
              <v-tab>Sales</v-tab>
              <v-tab>Purchase</v-tab>
              <v-tab>Payment</v-tab>
            
             <v-tab-item>
            <v-data-table
              :headers="headers"
              :items="desserts"
              :hide-default-footer="true"
              class="reporttable"
            ></v-data-table>
             </v-tab-item>
              <v-tab-item>
                  <v-data-table
              :headers="headers"
              :items="desserts"
              :hide-default-footer="true"
              class="reporttable"
            ></v-data-table>
              </v-tab-item>
               <v-tab-item>
                   <v-data-table
              :headers="headers"
              :items="desserts"
              :hide-default-footer="true"
              class="reporttable"
            ></v-data-table>
               </v-tab-item>
               </v-tabs>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="4" md="4">
        <v-card flat>
          <v-card-title style="font-size:16px;"
            >Best Selling Products</v-card-title
          >
          <v-card-text>
            <v-list>
              <template v-for="(item, index) in items">
                <v-list-item :key="item.title">
                  <div class="product-img">
                    <v-img :src="item.avatar"></v-img>
                  </div>
                  <v-list-item-content>
                    <v-list-item-subtitle v-html="item.category"></v-list-item-subtitle>
                    <v-list-item-title style="font-weight:600" v-html="item.name"></v-list-item-title>
                     <v-list-item-subtitle v-html="item.price"></v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "AppDashboard",
  head() {
    return {
      title: "Dashboard"
    };
  },

  data() {
    return {
      lineseries: [
        {
          name: "Desktops",
          data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }
      ],
      items: [
        {
          avatar: require('../../assets/image/fish.png'),
          category: "Fish",
          name: "Katla Fish",
          price: "230-250",
        },
        {
           avatar: require('../../assets/image/mango.png'),
          category: "Fruits",
          name: "Mango",
          price: "120-150",
        }
      ],
      headers: [
        {
          text: "Dessert (100g serving)",
          align: "start",
          sortable: false,
          value: "name"
        },
        { text: "Calories", value: "calories" },
        { text: "Fat (g)", value: "fat" },
        { text: "Carbs (g)", value: "carbs" },
        { text: "Protein (g)", value: "protein" },
        { text: "Iron (%)", value: "iron" },
        { text: "Fat (g)", value: "fat" },
        { text: "Carbs (g)", value: "carbs" }
      ],
      desserts: [
        {
          name: "Frozen Yogurt",
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
          iron: "1%",
          fat: 6.0,
          carbs: 24
        },
        {
          name: "Ice cream sandwich",
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
          iron: "1%",
          fat: 6.0,
          carbs: 24
        },
        {
          name: "Eclair",
          calories: 262,
          fat: 16.0,
          carbs: 23,
          protein: 6.0,
          iron: "7%",
          fat: 6.0,
          carbs: 24
        },
        {
          name: "Cupcake",
          calories: 305,
          fat: 3.7,
          carbs: 67,
          protein: 4.3,
          iron: "8%",
          fat: 6.0,
          carbs: 24
        }
      ],
      piedata: [404, 550, 1300],
      chartOptions: {
        chart: {
          type: "pie"
        },
        noData: {
          text: "Loading..."
        },
        labels: ["Total Earning", "Total Expense", "Net Profit"],
        responsive: [
          {
            breakpoint: 1369,
            options: {
              chart: {
                width: 300,
              },
              legend: {
                position: "bottom"
              }
            }
          }
        ]
      },
      dashboardinfo: {},
      reportfor: "yearly",
      paymentheaders: [
        {
          sortable: false,
          text: this.$t("payment_type"),
          value: "select_mode"
        },
        {
          sortable: false,
          text: this.$t("payment_via"),
          value: "bank_name"
        },
        {
          sortable: false,
          text: this.$t("amount"),
          value: "payment_amount",
          align: "right"
        },
        {
          sortable: false,
          text: this.$t("date"),
          value: "created_at",
          align: "right"
        }
      ]
    };
  },
  mounted() {
    //this.$store.commit("title/SET_TITLE", this.$t("dashboard"));
    //this.getDashboardData();
  },
  computed: {
    user_business_location() {
      return this.$auth.user.data.user_business_location;
    },
    lineOptions() {
      return {
        chart: {
          type: "line",
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: "smooth"
        },
        noData: {
          text: "Loading..."
        },
        xaxis: {
          categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep"
          ]
        }
      };
    }
  },
  methods: {
    getPercentage(amount) {
      const sum = this.dashboardinfo.popular_fish
        .map(item => item.total_amount)
        .reduce((prev, curr) => prev + curr, 0);
      return ((amount / sum) * 100).toFixed(2) + "%";
    },
    getDashboardData() {
      this.$axios.get("/dashboard-data").then(res => {
        this.dashboardinfo = res.data.data;
      });
    },
    complete(index) {
      this.list[index] = !this.list[index];
    }
  },
  watch: {
    reportfor(val) {
      this.$axios.get("/dashboard-data?reportfor=" + val).then(res => {
        this.dashboardinfo = res.data.data;
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.v-data-table__wrapper {
  border: 1px solid #ebebeb;
}
@media (min-width: 1264px) and (max-width: 2000px) {
  .flex.lg5-custom {
    width: 20%;
    max-width: 20%;
    flex-basis: 20%;
  }
}
.v-card
{
  border-radius: 8px;
}
.v-application .title {
  line-height: 1rem !important;
}
@media (min-width: 950px) {
  .dash-card-margin {
    margin-top: -100px;
  }
}
.body-1 {
  color: #000 !important;
}
.arot-commission {
  font-size: 2.5rem !important;
  color: #303f9f;
}
.market-commission {
  font-size: 2.5rem !important;
  color: #388e3c;
}
.v-btn--active {
  background: #4caf50 !important;
}
.store-card .counter {
  font-size: 24px;
  color: #555bfe;
}
.store-card .counter {
  font-size: 24px;
  color: #555bfe;
}
.revenue-card .counter {
  font-size: 24px;
  color: #e98c00;
}
.expense-card .counter {
  font-size: 24px;
  color: #d50000;
}
.commission-card .counter {
  font-size: 24px;
  color: #0c75ff;
}
.profits-card .counter {
  font-size: 24px;
  color: #00a743;
}
.details {
  text-align: right;
  margin-bottom: 0px !important;
}
.product-img
{
  width:60px;
  height: 60px;
  background: #e6e6f7;
  padding: 10px;
  margin-right: 10px;
}

.top-card .v-card:hover
{
  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important;
}
</style>
