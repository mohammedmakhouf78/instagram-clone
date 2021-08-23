require('./bootstrap');

import Vue from 'vue'
import router from './router'
import ViewUI from 'view-design'
import 'view-design/dist/styles/iview.css'
import common from './common'
import store from './store'
import Axios from 'axios'
import InfiniteLoading from 'vue-infinite-loading'

Vue.prototype.$http = Axios;

Vue.mixin(common)
Vue.use(ViewUI)
Vue.use(InfiniteLoading)
Vue.component('welcome',require('./components/welcome.vue').default)

const app = new Vue({
    el:'#app',
    router,
    store
})

