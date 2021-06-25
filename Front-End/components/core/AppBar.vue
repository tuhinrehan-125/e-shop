<template>
  <v-app-bar id="app-bar" dark app flat color="#555BFE" height="75">
    <v-app-bar-nav-icon @click="setDrawer(!drawer)"></v-app-bar-nav-icon>
    <v-toolbar-title>
      <NuxtLink to="/dashboard">
        <img src="~/assets/image/logo2.png" />
        <span class="logo-name">E-Shop</span>
      </NuxtLink>
    </v-toolbar-title>
    <v-spacer />

    <!-- <v-text-field
      label="Search"
      color="secondary"
      hide-details
      style="max-width: 165px"
    >
      <template v-if="$vuetify.breakpoint.mdAndUp" v-slot:append-outer>
        <v-btn class="mt-n2" elevation="1" fab small>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>
      </template>
    </v-text-field> -->
    <!-- <NuxtLink to="/pos">
    <v-btn elevation="2" medium dark>POS</v-btn>
    </NuxtLink> -->

    <div class="mx-3" />
    <v-menu
      bottom
      left
      offset-y
      origin="top right"
      transition="scale-transition"
    >
      <template v-slot:activator="{ attrs, on }">
        <v-btn class="ml-2" min-width="0" text v-bind="attrs" v-on="on">
          <v-badge color="red" overlap>
            <template v-slot:badge>
              <span>5</span>
            </template>
            <v-icon>mdi-bell</v-icon>
          </v-badge>
        </v-btn>
      </template>
      <v-list :tile="false" nav>
        <div>
          <app-bar-item v-for="(n, i) in notifications" :key="`item-${i}`">
            <v-list-item-title v-text="n" />
          </app-bar-item>
        </div>
      </v-list>
    </v-menu>
    <v-select
      style="max-width: 100px; top: 10px"
      :items="items"
      label="Language"
      item-text="name"
      item-value="code"
      dense
      outlined
      v-model="getLang"
      @change="chnageLang"
    ></v-select>
    <v-menu offset-y class="avatar-menu">
      <template v-slot:activator="{ attrs, on }">
        <v-avatar class="ml-4" v-bind="attrs" v-on="on">
          <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
        </v-avatar>
      </template>

      <v-list>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>MD Imtiaz Ahmed</v-list-item-title>
            <v-list-item-subtitle>Founder of Vuetify</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item link>
          <v-list-item-content>
            <v-list-item-title>Profile</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link>
          <v-list-item-content>
            <v-list-item-title>Setting</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link @click="logout">
          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu>
    <!-- <v-btn
      class="ml-2"
      min-width="0"
      text
    >
      <v-icon>mdi-account</v-icon>
    </v-btn> -->

    <!-- <v-list :tile="false" nav>
        <v-list-item-group color="primary">
          <v-list-item to="/user/profile">
            <v-list-item-content>
              <v-list-item-title>My Profile</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title @click="logout">Logout</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-menu> -->
  </v-app-bar>
</template>

<script>
// Components
import { VHover, VListItem } from "vuetify";

// Utilities
import { mapState, mapMutations } from "vuex";

export default {
  name: "DashboardCoreAppBar",

  components: {
    AppBarItem: {
      render(h) {
        return h(VHover, {
          scopedSlots: {
            default: ({ hover }) => {
              return h(
                VListItem,
                {
                  attrs: this.$attrs,
                  class: {
                    "black--text": !hover,
                    "white--text secondary elevation-12": hover
                  },
                  props: {
                    activeClass: "",
                    dark: hover,
                    link: true,
                    ...this.$attrs
                  }
                },
                this.$slots.default
              );
            }
          }
        });
      }
    }
  },

  props: {
    value: {
      type: Boolean,
      default: false
    }
  },

  data: () => ({
    items: [
      {
        code: "en",
        name: "EN"
      },
      {
        code: "bn",
        name: "BN"
      }
    ],
    notifications: [
      "Mike John Responded to your email",
      "You have 5 new tasks",
      "You're now friends with Andrew",
      "Another Notification",
      "Another one"
    ],
    getLang: ""
  }),
  mounted() {
    this.getLang = localStorage.getItem("lang")
      ? localStorage.getItem("lang")
      : "bn";
  },

  computed: {
    ...mapState(["drawer"]),
    headline() {
      return "";
      //return this.$store.getters['title/pagetitle'];
    }
  },

  methods: {
    ...mapMutations({
      setDrawer: "SET_DRAWER"
    }),
    async logout() {
      await this.$auth.logout();
    },
    chnageLang(value) {
      localStorage.setItem("lang", value);
      this.$store.commit("SET_LANG", value);
      this.$i18n.locale = value;
    }
  }
};
</script>
<style scoped>
.v-application a {
  color: transparent !important;
}
.v-app-bar.v-app-bar--fixed {
  z-index: 1000;
  left: 0px !important;
}

.v-toolbar__title a {
  display: inline-flex;
  margin-top: 10px;
}
.logo-name {
  color: #fff;
  margin-left: 10px;
  font-weight: 600;
}
.avatar-menu .v-menu__content::before
{
  content:"";
  width: 0px;
  height: 0px;
  border-top: solid 7px #fff;
  border-left: solid 7px transparent;
  border-right: solid 7px transparent;
  top: 30px;
  position: absolute;
  margin: 0 auto;
  text-align: center;
}
</style>
