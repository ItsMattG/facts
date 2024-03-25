import { createApp, h } from 'vue/dist/vue.esm-bundler.js';
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Quasar } from 'quasar'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'

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
        app.use(Quasar, {
			plugins:{},
		});
        return app.mount(el);
    },
});
