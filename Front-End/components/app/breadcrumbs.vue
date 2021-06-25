<template>
  <v-card flat>
    <v-card-text>
      <v-layout row>
        <v-flex xl8 sm6 md6>
          <div class="title-bar">
            <img src="~assets/image/home-sharp.svg" />
            <h3>{{title}}</h3>
          </div>
          <p>Home-Dashboard</p>
        </v-flex>
        <v-flex xl4 sm6 md6 >
           <v-row no-gutters class="justify-end">
              <v-col cols="3">
              <v-btn to="/pos" tile color="#15C472" class="float-right"
                ><v-icon left>mdi-cart</v-icon>POS</v-btn
              >
            </v-col>
            <v-col cols="3" v-if="$route.name=='dashboard'">
              <v-select
                :items="stores"
                v-model="store"
                item-text="name"
                item-value="id"
                solo
                outlined
                small
                dense
                flat
              ></v-select>
            </v-col>
             <v-col cols="3"  v-if="$route.name=='dashboard'">
              <v-select
              v-model="report"
                :items="reports"
                solo
                outlined
                small
                dense
                flat
              ></v-select>
            </v-col>
          </v-row>
        </v-flex>
      </v-layout>
    </v-card-text>
  </v-card>
</template>
<script>
export default {
  name: "breadcrumb",
  data() {
    return {
      store:1,
      report:"Daily",
      reports:['Daily','Weekly','Monthly','Yearly'],
      title:'',

    };
  },
  computed: {
    stores() {
      return this.$auth.user.data.user_business_location;
    }
  },
  mounted() {},
  methods: {
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
  watch:{
    $route (to, from){
       this.title=this.capitalizeFirstLetter(this.$route.name)
    }
} 
};
</script>

<style scoped>
.title-bar {
  display: inline-flex;
}
.title-bar h3 {
  margin-left: 5px;
}
.side-bar {
  position: absolute;
  display: flex;
  right: 20px;
}
.row {
  margin: 0px;
}
</style>
