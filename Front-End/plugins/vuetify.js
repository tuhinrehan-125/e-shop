import Vue from 'vue'
import Vuetify from 'vuetify'
//import i18n from '@/i18n'
import '@mdi/font/css/materialdesignicons.css'
import '@/sass/styles.sass'
import '@/sass/variables.scss'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

const theme = {
  primary: '#555BFE',
  secondary: '#0C75FF',
  accent: '#9C27b0',
  info: '#00CAE3',
  success: '#15C472',
}

export default ctx => {
  const vuetify = new Vuetify({
    theme: {
      themes: {
        dark: theme,
        light: theme,
      },
    },
  })
  ctx.app.vuetify = vuetify
  ctx.$vuetify = vuetify.framework
}

