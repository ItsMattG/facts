import { createApp } from 'vue/dist/vue.esm-bundler.js';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import Facts from './components/Facts.vue'
import LoginRegister from './components/LoginRegister.vue'
import '@mdi/font/css/materialdesignicons.css'

const vuetify = createVuetify({
	components,
	directives,
})

const app = createApp()

app.component('Facts', Facts)
app.component('LoginRegister', LoginRegister)

app.use(vuetify).mount('#app')
