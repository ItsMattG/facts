<template>
	<div class="wrapper">
		<div class="container">
			<h1 class="title">Choose a Fun Fact!</h1>
			<div class="buttons">
				<button @click="selectFact('date')" :class="{ selected: selectedFact === 'date' }">Date</button>
				<button @click="selectFact('math')" :class="{ selected: selectedFact === 'math' }">Math</button>
				<button @click="selectFact('random')" :class="{ selected: selectedFact === 'random' }">Random</button>
				<button @click="selectFact('trivia')" :class="{ selected: selectedFact === 'trivia' }">Trivia</button>
				<button @click="selectFact('year')" :class="{ selected: selectedFact === 'year' }">Year</button>
			</div>
		</div>
		<div class="bottom-content">
			<div class="input-field" v-if="showInputField">
				<input v-model="inputValue" v-if="selectedFact === 'date'" type="text" placeholder="DD/MM" pattern="\d{2}/\d{2}">
				<input v-model="inputValue" v-else type="number" placeholder="Enter a number">
			</div>
			<div class="fetch-button-container">
				<button @click="fetchFact" v-if="selectedFact">Get Fact!</button>
				<div class="response" v-if="response">{{ response.text }}</div>
				<div v-show="showError" class="error-message">
					Invalid date format. Please enter a valid date format (DD/MM).
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			baseUrl: 'https://numbersapi.p.rapidapi.com/',
			apiSearch: '',
			selectedFact: '',
			inputValue: '',
			response: {},
			showError: false,
		}
	},
	methods: {
		selectFact(fact) {
			this.showError = false;
			if (this.selectedFact !== fact) {
				this.selectedFact = fact;
				this.inputValue = '';
				this.response = '';
			}
		},
		isValidDate(dateString) {
			// Check if date is in the format DD/MM
			const dateRegex = /^\d{2}\/\d{2}$/;
			return dateRegex.test(dateString);
		},
		async fetchFact() {
			if (!this.selectedFact) {
				console.error('No fact selected');
				return;
			}

			switch (this.selectedFact) {
				case 'date':
					if (!this.isValidDate(this.inputValue)) {
						this.showError = true;
						return;
					}
					this.showError = false;
					this.apiSearch = `${this.inputValue + '/date'}`;
					break;
				case 'math':
					this.apiSearch = `${this.inputValue + '/math'}`;
					break;
				case 'random':
					this.apiSearch = 'random/trivia';
					break;
				case 'trivia':
					this.apiSearch = `${this.inputValue + '/trivia'}`;
					break;
				case 'year':
					this.apiSearch = `${this.inputValue + '/year'}`;
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
	},
	computed: {
		showInputField() {
			if (this.selectedFact !== '') {
				return this.selectedFact !== 'random';
			}
			return false;
		},
	}
}

</script>