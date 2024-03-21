import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import Facts from './components/Facts.vue';
import axios from 'axios';
import { ref } from 'vue';

const app = createApp({
	components: {
		Facts,
	}
});

app.config.globalProperties.$axios = axios;

app.mount('#app');
