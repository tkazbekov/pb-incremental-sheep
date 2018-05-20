import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import App from './App.vue';
import Pen from './components/Pen.vue';
// import Example from './components/Example.vue';

const routes = [
  {
      name: 'Pen',
      path: '/',
      component: Pen
  }
];

const router = new VueRouter({ mode: 'history', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');