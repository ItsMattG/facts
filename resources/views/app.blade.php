<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		@vite('resources/js/app.js')
		@vite('resources/css/app.css')
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vuetify@3.0.0-alpha.10/dist/vuetify.min.css">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
		@vite('resources/js/app.js') @inertiaHead
	</head>
    <body>
		<div id="app">
			@inertia('my-app')
		</div>
		<script src="https://cdn.jsdelivr.net/npm/vue@next/dist/vue.global.prod.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@vuetifyjs/vuetify@3.0.0-alpha.10"></script>
    </body>
</html>
