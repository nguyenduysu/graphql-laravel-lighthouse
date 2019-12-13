require('./bootstrap');
import Vue from 'vue/dist/vue.js'
import VueApollo from 'vue-apollo';
import { apollo } from './apollo'

window.Vue = require('vue');

Vue.use(VueApollo);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('post-updated-component', require('./components/PostUpdatedComponent.vue').default);
Vue.component('comment-created-component', require('./components/CommentCreatedComponent.vue').default);

const app = new Vue({
    el: '#app',
    apolloProvider: apollo,
});
