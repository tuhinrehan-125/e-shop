<template>
  <v-navigation-drawer
    v-model="drawer"
    app
    max-width="160"
    white
    :temporary="temporary"
    :class="temporary ? 'pt-0' : 'pt-20'"
  >
    <v-list dense expand nav>
      <template v-for="(item, i) in columns">
        <v-list-item
          v-if="!item.children"
          color="white"
          :key="`subheader-${i}`"
          :to="item.to"
        >
          <v-list-item-icon>
            <v-icon small>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
        <!-- else if it has children -->
        <v-list-group
          v-else-if="item.children && hasPermission(permissions, item.children)"
          :group="item.to"
          color="white"
          :key="`subheader-${i}`"
          :prepend-icon="item.icon"
        >
          <!-- this template is for the title of top-level items with children -->
          <template #activator>
            <v-list-item-content>
              <v-list-item-title>
                <!-- <v-icon>{{ item.icon }}</v-icon> -->
                {{ item.title }}
              </v-list-item-title>
            </v-list-item-content>
          </template>
          <!-- this template is for the children/sub-items (2nd level) -->
          <template v-for="(subItem, j) in item.children">
            <!-- another v-if to determine if there's a 3rd level -->
            <!-- if there is NOT a 3rd level -->
            <v-list-item
              v-if="
                !subItem.children && permissions.includes(subItem.permission)
              "
              class="ml-5"
              :key="`subheader-${j}`"
              :to="item.to + subItem.to"
            >
              <v-list-item-icon class="mr-4">
                <v-icon v-text="subItem.icon" small />
              </v-list-item-icon>
              <v-list-item-title class="ml-0">
                {{ subItem.title }}
              </v-list-item-title>
            </v-list-item>
          </template>
        </v-list-group>
      </template>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
// Utilities
import { mapState } from "vuex";
export default {
  name: "DashboardCoreDrawer",
  props: {
    expandOnHover: {
      type: Boolean,
      default: false
    },
    routeChange: {
      type: Boolean,
      default: false
    },
    temporary: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {};
  },
  mounted() {},
  computed: {
    ...mapState(["barColor", "barImage"]),
    drawer: {
      get() {
        return this.$store.state.drawer;
      },
      set(val) {
        this.$store.commit("SET_DRAWER", val);
      }
    },
    profile() {
      return {
        avatar: true,
        title: this.avatar
      };
    },
    permissions() {
      return this.$store.state.auth.user.data.permissions;
    },
    columns() {
      return [
        {
          icon: "mdi-view-dashboard",
          title: this.$t("dashboard"),
          to: "/dashboard"
        },
        {
          icon: "mdi-account",
          title: this.$t("products"),
          to: "/product",
          children: [
            {
              icon: "mdi-shape",
              title: this.$t("Product List"),
              to: "/list",
              permission: "product.view"
            },
            {
              icon: "mdi-shape",
              title: this.$t("Add Product"),
              to: "/add",
              permission: "product.add"
            },
            {
              icon: "mdi-shape",
              title: this.$t("category"),
              to: "/category",
              permission: "category.view"
            },
            {
              icon: "mdi-shape",
              title: this.$t("Brand"),
              to: "/brand",
              permission: "brand.view"
            },
            {
              icon: "mdi-shape",
              title: this.$t("Unit"),
              to: "/unit",
              permission: "unit.view"
            }
          ]
        },
        {
          icon: "mdi-account-box-multiple",
          title: this.$t("Contacts"),
          to: "/contact",
          children: [
            {
              icon: "mdi-account-arrow-left-outline",
              title: this.$t("supplier"),
              to: "/supplier",
              permission: "supplier.view"
            },
            {
              icon: "mdi-account-arrow-right-outline",
              title: this.$t("customers"),
              to: "/customers",
              permission: "customer.view"
            },
            {
              icon: "mdi-account-group-outline",
              title: this.$t("customer_group"),
              to: "/customer-groups",
              permission: "customer_group.view"
            }
          ]
        },
        {
          icon: "mdi-cart",
          title: this.$t("Purchase"),
          to: "/purchase",
          children: [
            {
              icon: "mdi-format-list-bulleted",
              title: this.$t("Purchase List"),
              to: "/list",
              permission: "purchase.view"
            },
            {
              icon: "mdi-plus-circle-outline",
              title: this.$t("Add Purchase"),
              to: "/add",
              permission: "purchase.add"
            },
            {
              icon: "mdi-reply",
              title: this.$t("Return Purchase"),
              to: "/return",
              permission: "purchase.return"
            }
          ]
        },
        {
          icon: "mdi-cart-arrow-right",
          title: this.$t("Sell"),
          to: "/sell",
          children: [
            {
              icon: "mdi-format-list-bulleted",
              title: this.$t("All Sales"),
              to: "/list",
              permission: "sell.view"
            },
            {
              icon: "mdi-plus-circle-outline",
              title: this.$t("Add Sell"),
              to: "/create",
              permission: "sell.add"
            },
            {
              icon: "mdi-reply",
              title: this.$t("Return Sell"),
              to: "/return",
              permission: "sell.return"
            }
          ]
        },
        {
          icon: "mdi-cart-arrow-right",
          title: this.$t("Quotation"),
          to: "/quotation",
          children: [
            {
              icon: "mdi-format-list-bulleted",
              title: this.$t("Quotation List"),
              to: "/list",
              permission: "sell.view"
            },
            {
              icon: "mdi-plus-circle-outline",
              title: this.$t("Add Quotation"),
              to: "/create",
              permission: "sell.add"
            }
          ]
        },
        {
          icon: "mdi-inbox-arrow-up",
          title: this.$t("Stock Transfer"),
          to: "/stockTransfer",
          children: [
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("Stock Transfer List"),
              to: "/list",
              permission: "stock_transfer.view"
            },
            {
              icon: "mdi-shape",
              title: this.$t("Add Stock Transfer"),
              to: "/add",
              permission: "stock_transfer.add"
            }
          ]
        },
        {
          icon: "mdi-inbox-arrow-up",
          title: this.$t("expense"),
          to: "/expense",
          children: [
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("expense_list"),
              to: "/list",
              permission: "expense.view"
            },
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("add_expense"),
              to: "/add",
              permission: "expense.add"
            },
            {
              icon: "mdi-shape",
              title: this.$t("expense_category"),
              to: "/category",
              permission: "expense_category.view"
            }
          ]
        },
        {
          title: this.$t("reports"),
          icon: "mdi-file-chart",
          to: "/reports",
          children: [
            {
              icon: "mdi-cart-arrow-right",
              title: this.$t("sales_report"),
              to: "/sales",
              permission: "report.view"
            },
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("expense_report"),
              to: "/expense",
              permission: "report.view"
            },
            {
              icon: "mdi-inbox-arrow-down",
              title: this.$t("collection_report"),
              to: "/collection",
              permission: "report.view"
            },
            {
              icon: "mdi-shape",
              title: this.$t("payment_report"),
              to: "/payment",
              permission: "report.view"
            }
          ]
        },
        {
          title: this.$t("User"),
          icon: "mdi-account-box",
          to: "/user",
          children: [
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("User List"),
              to: "/user-list",
              permission: "user.view"
            },
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("Role"),
              to: "/role",
              permission: "user.role"
            }
          ]
        },
        {
          title: this.$t("settings"),
          icon: "mdi-cog-outline",
          to: "/settings",
          children: [
            {
              icon: "mdi-cart-arrow-right",
              title: this.$t("Business Settings"),
              to: "/business",
              permission: "settings.business"
            },
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("Business Locations"),
              to: "/location",
              permission: "settings.locations"
            }
          ]
        }
      ];
    }
  },
  methods: {
    hasPermission(array1, array2) {
      let data = [];
      for (let index = 0; index < array2.length; ++index) {
        data.push(array2[index].permission);
      }
      const intersection = array1.filter(element => data.includes(element));

      if (intersection.length > 0) {
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>
<style scoped>
.v-navigation-drawer {
  position: fixed;
  top: 0px;
  left: 0;
  padding-top: 60px;
  min-height: 100vh;
  width: 230px;
  background-color: #fff;
}
.pt-20 {
  padding-top: 80px;
}
</style>
