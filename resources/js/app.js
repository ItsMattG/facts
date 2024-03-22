import { createApp } from 'vue/dist/vue.esm-bundler.js';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import Facts from './components/Facts.vue'

const vuetify = createVuetify({
	components,
	directives,
})

const app = createApp()

app.component('Facts', Facts)

app.use(vuetify).mount('#app')
