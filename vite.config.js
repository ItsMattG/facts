import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
		laravel({
			input: ['resources/css/app.css', 'resources/js/app.js'],
			output: 'public/build', // Ensure this points to the correct output directory
			refresh: true,
		}),
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false,
				},
			},
		}),
    ],
});
