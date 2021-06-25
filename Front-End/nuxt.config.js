export default {
  // Disable server-side rendering (https://go.nuxtjs.dev/ssr-mode)
  ssr: false,
  target: 'static',

  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    title: 'E-Shop',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      {
        rel: 'stylesheet',
        href: 'https://fonts.googleapis.com/css?family=Raleway:400|Roboto+Slab:200&display=swap'
      }
    ]
  },
  /*
   ** Customize the progress-bar color
   */
  loading: {
    color: '#00cae3b8'
  },
  transition: {
    name: 'page',
    mode: 'out-in'
  },

  loadingIndicator: {
    name: 'cube-grid',
    color: '#fff',
    background: '#49899D'
  },


  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: [
    '~/assets/css/style.css'
  ],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [
    { src: '~/plugins/base.js', ssr: false },
    { src: '~/plugins/refresh.js', ssr: false },
    { src: '~/plugins/vuetify.js', ssr: false },
    { src: '~/plugins/i18n.js' },
    { src: '~/plugins/vue-gates.js', ssr: false },
    { src: "~/plugins/apexcharts.js", mode: "client", ssr: false },
    { src: '@/plugins/vue-html2pdf', mode: 'client' }
  ],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    '@nuxtjs/pwa',
    '@nuxtjs/svg',
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/pwa',
    '@nuxtjs/auth',
  ],
  router: {
    middleware: ['auth']
  },
  // Axios module configuration (https://go.nuxtjs.dev/config-axios)
  axios: {
    baseURL: 'http://localhost:8000/api'
    //baseURL: 'https://eshop.orionisbd.com/backend/api'
  },
  //auth strategies
  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: 'auth/login',
            method: 'post',
            propertyName: 'access_token'
          },
          logout: {
            url: 'auth/logout',
            method: 'post'
          },
          user: {
            url: 'auth/userinfo',
            method: 'get',
            propertyName: false
          },
        },
      }
    },
    redirect: {
      login: '/',
      logout: '/'
    },
    resetOnError: true,
  },
  /* add pwa message */
  pwa: {
    meta: {
      title: 'E-shop',
      author: 'Orionis Team',
    },
    manifest: {
      name: 'E-shop',
      short_name: 'E-shop',
      lang: 'en',
    },
    // workbox: {
    //   pagesURLPattern:"/clients",
    //   runtimeCaching: [
    //     {
    //       urlPattern:  new RegExp("/clients/(.*)"),
    //       strategyOptions: {
    //         cacheName: 'our-cache',
    //       },
    //       strategyPlugins: [{
    //          use: 'Expiration',
    //          config: {
    //            maxEntries: 10,
    //            maxAgeSeconds: 300
    //          }
    //        }]
    //     }
    //   ],
    //   cacheNames: {
    //     prefix: "my-app",
    //     suffix: "v1",
    //   },
    // }
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {

  }
}
