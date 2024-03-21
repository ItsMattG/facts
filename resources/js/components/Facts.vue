<template>
	<div class="container">
		<h1 class="title">Choose a Fun Fact!</h1>
		<div class="buttons">
			<button @click="fetchFact('date')">Date</button>
			<button @click="fetchFact('math')">Math</button>
			<button @click="fetchFact('random')">Random</button>
			<button @click="fetchFact('trivia')">Trivia</button>
			<button @click="fetchFact('year')">Year</button>
		</div>
		<div class="response" v-if="response">{{ response.text }}</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			baseUrl: 'https://numbersapi.p.rapidapi.com/',
			apiSearch: '',
			response: {}
		}
	},
	methods: {
		async fetchFact(topic) {
			console.log(topic);
			switch (topic) {
				case 'date':
					this.apiSearch = '6/22/date';
					break;
				case 'math':
					this.apiSearch = '1729/math';
					break;
				case 'random':
					this.apiSearch = 'random/trivia';
					break;
				case 'trivia':
					this.apiSearch = '42/trivia';
					break;
				case 'year':
					this.apiSearch = '1492/year';
					break;
			}

			var options = {
				method: 'GET',
				url: this.baseUrl + this.apiSearch,
				params: {
					fragment: 'true',
					json: 'true'
				},
				headers: {
					'X-RapidAPI-Key': '8c696eead1mshc02929595b56419p161ff0jsn37c00253466c',
					'X-RapidAPI-Host': 'numbersapi.p.rapidapi.com'
				}
			};

			try {
				var res = await axios.request(options);
				this.response = res.data;
			} catch (error) {
				console.error('Error fetching data:', error);
			}
		}
	}
}

</script>