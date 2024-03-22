<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" md="8">
				<h1 class="title pb-8">Generate a Fun Fact!</h1>
				<v-row justify="space-between">
					<v-btn class="fact-button" @click="selectFact('date')" :class="{ selected: selectedFact === 'date' }">Date</v-btn>
					<v-btn class="fact-button" @click="selectFact('math')" :class="{ selected: selectedFact === 'math' }">Math</v-btn>
					<v-btn class="fact-button" @click="selectFact('random')" :class="{ selected: selectedFact === 'random' }">Random</v-btn>
					<v-btn class="fact-button" @click="selectFact('trivia')" :class="{ selected: selectedFact === 'trivia' }">Trivia</v-btn>
					<v-btn class="fact-button" @click="selectFact('year')" :class="{ selected: selectedFact === 'year' }">Year</v-btn>
				</v-row>
			</v-col>
		</v-row>
		<v-row justify="center" class="bottom-content pt-4">
			<v-col cols="12" md="8">
				<v-row justify="center" v-if="selectedFact && selectedFact !== 'random'">
					<v-text-field v-model="inputValue" v-if="selectedFact === 'date'" type="text" placeholder="DD/MM"></v-text-field>
					<v-text-field v-model="inputValue" v-else type="number" placeholder="Enter a number"></v-text-field>
				</v-row>
				<v-row justify="center" class="fetch-button-container" :class="{ 'pt-6': selectedFact === 'random' }">
					<v-btn class="action-button" @click="fetchFact" v-if="selectedFact">Get Fact!</v-btn>
				</v-row>
				<v-row justify="center">
					<v-col cols="12" md="12">
						<div class="response-container">
							<div class="response" v-if="Object.keys(response).length > 0 && selectedFact === 'random'">{{ response.number }}</div>
							<div class="response" v-if="Object.keys(response).length > 0 && selectedFact === 'date'">{{ response.year }}</div>
							<div class="response" v-if="Object.keys(response).length > 0">{{ responseTextFormatted }}</div>
						</div>
					</v-col>
				</v-row>

				<v-row justify="center">
					<v-alert dense v-show="showError" type="error" transition="scale-transition">
						Invalid date format. Please enter a valid date format (DD/MM).
					</v-alert>
				</v-row>
			</v-col>
		</v-row>
	</v-container>
</template>

<script>
import axios from 'axios'

export default {
	data() {
		return {
			baseUrl: 'https://numbersapi.p.rapidapi.com/',
			apiSearch: '',
			selectedFact: '',
			inputValue: '',
			response: {},
			showError: false,
		};
	},
	methods: {
		selectFact(fact) {
			this.showError = false;
			if (this.selectedFact !== fact) {
				this.selectedFact = fact;
				this.inputValue = '';
				this.response = {};
			}
		},
		isValidDate(dateString) {
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
			console.log(this.baseUrl + this.apiSearch)
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
				console.log(this.response.text);
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
		responseTextFormatted() {
			return this.response.text.charAt(0).toUpperCase() + this.response.text.slice(1);
		}
	}
};
</script>
