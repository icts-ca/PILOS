require('./bootstrap');

window.Vue = require('vue');
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import App from './views/App';
import router from './router';

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.component('secret-component', require('./components/SecretComponent.vue').default);

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
