import { createApp, h } from 'vue/dist/vue.esm-bundler.js';
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import Facts from './components/Facts.vue'
import Register from './components/Register.vue'
import Login from './components/Login.vue'
import '@mdi/font/css/materialdesignicons.css'

const vuetify = createVuetify({
	components,
	directives,
})

createInertiaApp({
	id: 'my-app',
    resolve: (name) =>
		resolvePageComponent(
			`./components/${name}.vue`,
			import.meta.glob("./components/**/*.vue")
		),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(vuetify);
        return app.mount(el);
    },
});
