/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import Layout from './Shared/Layout'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret,faCheckCircle,faEdit,faTrash } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

Vue.use(plugin)
Vue.prototype.$route = (...args) => route(...args).url();
library.add(faUserSecret,faCheckCircle,faEdit,faTrash);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('layout', Layout);
Vue.mixin({
    methods: {
      route: window.route,
      isRoute(...routes) {
        return routes.some(route => this.route().current(route));
      }
    }
  });
const el = document.getElementById('app')
if(el){
    new Vue({
      render: h => h(App, {
        props: {
          initialPage: JSON.parse(el.dataset.page),
          resolveComponent: name => require(`./Pages/${name}`).default,
        },
      })
    }).$mount(el)
}
