<template>
  <v-navigation-drawer
    v-model="drawer"
    app
    max-width="160"
    :dark="barColor !== 'rgba(228, 226, 226, 1), rgba(255, 255, 255, 0.7)'"
  >
    <v-list dense nav>
      <NuxtLink to="/dashboard">
        <v-list-item class="arot-logo">
          <img src="~/assets/image/logo.png" />
        </v-list-item>
      </NuxtLink>
    </v-list>
    <v-list dense expand nav>
      <template v-for="(item, i) in columns">
        <v-list-item
          v-if="!item.children"
          color="white"
          :key="`subheader-${i}`"
          :to="item.to"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
        <!-- else if it has children -->
        <v-list-group
          v-else
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
              v-if="!subItem.children"
              class="ml-5"
              :key="`subheader-${j}`"
              :to="item.to + subItem.to"
            >
              <v-list-item-icon class="mr-4">
                <v-icon v-text="subItem.icon" />
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
      default: false,
    },
    routeChange: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {};
  },
  computed: {
    ...mapState(["barColor", "barImage"]),
    drawer: {
      get() {
        return this.$store.state.drawer;
      },
      set(val) {
        this.$store.commit("SET_DRAWER", val);
      },
    },
    profile() {
      return {
        avatar: true,
        title: this.avatar,
      };
    },

    columns() {
      return [
        {
          icon: "mdi-view-dashboard",
          title: this.$t("dashboard"),
          to: "/dashboard",
        },
        {
          icon: "mdi-account",
          title: this.$t("products"),
          to: "/product",
          children: [
            {
              icon: "mdi-shape",
              title: this.$t("add_product"),
              to: "/add",
            },
            {
              icon: "mdi-shape",
              title: this.$t("add_category"),
              to: "/category",
            },
            {
              icon: "mdi-shape",
              title: this.$t("add_subcategory"),
              to: "/subcategory",
            },
          ],
        },
        {
          title: this.$t("clients"),
          icon: "mdi-account-arrow-left-outline",
          to: "/clients",
        },
        {
          title: this.$t("customers"),
          icon: "mdi-account-arrow-right-outline",
          to: "/customers",
        },
        {
          title: this.$t("payment"),
          icon: "mdi-credit-card",
          to: "/payment",
        },
        {
          title: this.$t("advance"),
          icon: "mdi-bank-transfer",
          to: "/advance",
        },
        {
          title: this.$t("collection"),
          icon: "mdi-inbox-arrow-down",
          to: "/collection",
        },
        {
          title: "Sales",
          icon: "mdi-cart",
          to: "/sales/create",
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
            },
            {
              icon: "mdi-shape",
              title: this.$t("expense_category"),
              to: "/category",
            },
          ],
        },
        {
          title: this.$t("reports"),
          icon: "mdi-file-chart",
          to: "/report",
          children: [
            {
              icon: "mdi-cart-arrow-right",
              title: this.$t("sales_report"),
              to: "/sales",
            },
            {
              icon: "mdi-inbox-arrow-up",
              title: this.$t("expense_report"),
              to: "/expense",
            },
            {
              icon: "mdi-inbox-arrow-down",
              title: this.$t("collection_report"),
              to: "/collection",
            },
            {
              icon: "mdi-shape",
              title: this.$t("payment_report"),
              to: "/payment",
            },
          ],
        },
        {
          title: this.$t("user_profile"),
          icon: "mdi-account-box",
          to: "/profile",
        },
        {
          title: this.$t("account"),
          icon: "mdi-bank",
          to: "/accounts",
        },
        {
          title: this.$t("settings"),
          icon: "mdi-cog-outline",
          to: "/settings",
        },
      ];
    },
  },
  methods: {
    log() {
      console.log(this.$route.path);
    },
  },
};
</script>

<style lang="sass">
@import '~vuetify/src/styles/tools/_rtl.sass'
#core-navigation-drawer
.v-list-group__header.v-list-item--active:before
    opacity: .24
    .v-list-item
    &__icon--text,
    &__icon:first-child
        justify-content: center
        text-align: center
        width: 20px
        +ltr()
        margin-right: 24px
        margin-left: 12px !important
        +rtl()
        margin-left: 24px
        margin-right: 12px !important
    .v-list--dense
    .v-list-item
        &__icon--text,
        &__icon:first-child
            margin-top: 10px
    .v-list-group--sub-group
    .v-list-item
        +ltr()
        padding-left: 8px
        +rtl()
        padding-right: 8px
    .v-list-group__header
        +ltr()
        padding-right: 0
        +rtl()
        padding-right: 0
        .v-list-item__icon--text
            margin-top: 19px
            order: 0
        .v-list-group__header__prepend-icon
            order: 2
            +ltr()
            margin-right: 8px
            +rtl()
            margin-left: 8px
</style>