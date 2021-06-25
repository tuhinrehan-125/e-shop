<template>
  <v-container grid-list-sm>
    <v-row>
      <v-col cols="12">
        <v-card class="mb-70">
          <v-card-title>
            <h2 class="overline font-weight-bold">Change Permission</h2>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-treeview
                  v-model="permissions"
                  :items="items"
                  :selection-type="selectionType"
                  selectable
                ></v-treeview>
              </v-col>
              <!-- <v-col cols="12" sm="6" md="6">
                <v-treeview
                  v-model="selection"
                  :selection-type="selectionType"
                  selectable
                  open-on-click
                  :items="items2"
                  return-object
                ></v-treeview>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-treeview
                  v-model="selection"
                  :selection-type="selectionType"
                  selectable
                  open-on-click
                  :items="items3"
                  return-object
                ></v-treeview>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-treeview
                  v-model="selection"
                  :selection-type="selectionType"
                  selectable
                  open-on-click
                  :items="items4"
                  return-object
                ></v-treeview>
              </v-col> -->

              <!-- <v-row justify="center" style="height: 150px" class="pb-16">
                <div>
                  <v-btn color="info" @click="">
                    {{ $t("save") }}
                  </v-btn>
                </div>
              </v-row> -->
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn color="teal" class="float-right" :loading="isLoading" @click="submit">
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "PermissionChnage",
  head: {
    title: "Change Permission"
  },
  components: {},
  data() {
    return {
      isLoading:false,
      permissions: [],
      selectionType: "leaf",
      items: [
        {
          id: 1,
          name: "User :",
          children: [
            { id: "user.view", name: "View" },
            { id: "user.add", name: "Add" },
            { id: "user.update", name: "Edit" },
            { id: "user.delete", name: "Delete" },
            { id: "user.role", name: "Role and permission" }
          ]
        },
        {
          id: 2,
          name: "Customer :",
          children: [
            { id: "customer.view", name: "View" },
            { id: "customer.add", name: "Add" },
            { id: "customer.update", name: "Edit" },
            { id: "customer.delete", name: "Delete" },
            { id: "customer_group.view", name: "Customer Group" }
          ]
        },
        {
          id: 3,
          name: "Supplier :",
          children: [
            { id: "supplier.view", name: "View" },
            { id: "supplier.add", name: "Add" },
            { id: "supplier.update", name: "Edit" },
            { id: "supplier.delete", name: "Delete" }
          ]
        },
        {
          id: 4,
          name: "Product :",
          children: [
            { id: "product.view", name: "View" },
            { id: "product.add", name: "Add" },
            { id: "product.update", name: "Edit" },
            { id: "product.delete", name: "Delete" }
          ]
        },
        {
          id: 5,
          name: "Brand :",
          children: [
            { id: "brand.view", name: "View" },
            { id: "brand.add", name: "Add" },
            { id: "brand.update", name: "Edit" },
            { id: "brand.delete", name: "Delete" }
          ]
        },
        {
          id: 6,
          name: "Unit :",
          children: [
            { id: "unit.view", name: "View" },
            { id: "unit.add", name: "Add" },
            { id: "unit.update", name: "Edit" },
            { id: "unit.delete", name: "Delete" }
          ]
        },
        {
          id: 7,
          name: "Category :",
          children: [
            { id: "category.view", name: "View" },
            { id: "category.add", name: "Add" },
            { id: "category.update", name: "Edit" },
            { id: "category.delete", name: "Delete" }
          ]
        },
        {
          id: 8,
          name: "Variation :",
          children: [
            { id: "variation.view", name: "View" },
            { id: "variation.add", name: "Add" },
            { id: "variation.update", name: "Edit" },
            { id: "variation.delete", name: "Delete" }
          ]
        },
        {
          id: 9,
          name: "Purchase :",
          children: [
            { id: "purchase.view", name: "View" },
            { id: "purchase.add", name: "Add" },
            { id: "purchase.update", name: "Edit" },
            { id: "purchase.delete", name: "Delete" },
            { id: "purchase_payment.view", name: "View Payment" },
            { id: "purchase_payment.add", name: "Add Payment" },
            { id: "purchase_payment.return", name: "Return Purchase" }
          ]
        },
        {
          id: 10,
          name: "Sell :",
          children: [
            { id: "sell.view", name: "View" },
            { id: "sell.add", name: "Add" },
            { id: "sell.update", name: "Edit" },
            { id: "sell.delete", name: "Delete" },
            { id: "sell_payment.view", name: "View Payment" },
            { id: "sell_payment.add", name: "Add Payment" },
            { id: "sell_payment.return", name: "Return Sell" }
          ]
        },
        {
          id: 11,
          name: "Stock Transfer :",
          children: [
            { id: "stock_transfer.list", name: "View" },
            { id: "stock_transfer.add", name: "Add" },
            { id: "stock_transfer.update", name: "Edit" }
          ]
        },
        {
          id: 12,
          name: "Expense :",
          children: [
            { id: "expense.view", name: "View" },
            { id: "expense.add", name: "Add" },
            { id: "expense.update", name: "Edit" },
            { id: "expense.delete", name: "Delete" }
          ]
        },
        {
          id: 13,
          name: "Reports :",
          children: [
            {
              id: "purchase_n_sell_report.view",
              name: "Purchase Sales Report"
            },
            { id: "contacts_report.view", name: "Contacts Report" },
            { id: "stock_report.view", name: "Stock Report" },
            { id: "expense_report.view", name: "Expense Report" }
          ]
        },
        {
          id: 14,
          name: "Settings :",
          children: [
            { id: "settings.business", name: "Business Setting" },
            { id: "settings.locations", name: "Store Setting" },
          ]
        },
      ]
    };
  },
  computed: {},
  async asyncData({ params, $axios }) {
    const { data } = await $axios.post(
      `role-has-permission/${params.id}`
    );
    const permissions=[]
    data.data.forEach(element => {
      permissions.push(element.name)
    });
     return {
      permissions:permissions
    };
  },
  mounted() {},
  methods: {
    async submit() {
      this.isLoading=true
      await this.$axios
        .post("/assign-permission", {
          permissions: this.permissions,
          role_id: this.$route.params.id
        })
        .then(res => {
          this.isLoading=false
          let data = {
            alert: true,
            message: "Permission Assigned Successfully",
            type: "success"
          };
          this.$store.commit("SET_ALERT", data);
        });
    }
  }
};
</script>

<style>
.v-treeview-node__children {
  display: flex;
  flex-wrap: wrap;
}

v-container {
  height: 100vh;
}
</style>
