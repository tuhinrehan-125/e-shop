import Vue from 'vue'
import axios from 'axios'

import VueGates from 'vue-gates'

Vue.use(VueGates, {
    persistent:true,
  });

export default (_context, inject,$axios) => {
    // _context.$axios.get('/role')
  inject('gates', Vue.prototype.$gates);
}