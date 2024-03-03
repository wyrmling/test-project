import './bootstrap';

import Vue from 'vue';
import vuetify from '@/vuetify';
import Register from '@/components/Register.vue';


const app = new Vue({
    el: '#app',
    components: {
        'register-form': Register,
    },
    // render: h => h(Register),
    vuetify,
});
