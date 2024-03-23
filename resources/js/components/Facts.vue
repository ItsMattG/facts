<template>
	<v-container class="pt-12">
		<v-row justify="center">
			<v-col cols="12" md="16">
				<!-- Login and Register Buttons -->
				<v-row justify="end" class="pb-4">
					<v-btn class="fact-button mr-3" :onClick="goToLogin">Login</v-btn>
					<v-btn class="fact-button" :onClick="goToRegister">Register</v-btn>
				</v-row>
				<h1 class="title pb-8">Generate a Fun Fact!</h1>

				<v-row justify="center" >
					<v-col cols="12" md="8">
						<v-row justify="center">
							<v-btn class="fact-button mr-3" @click="selectFact('date')" :class="{ selected: selectedFact === 'date' }">Date</v-btn>
							<v-btn class="fact-button mr-3" @click="selectFact('math')" :class="{ selected: selectedFact === 'math' }">Math</v-btn>
							<v-btn class="fact-button mr-3" @click="selectFact('random')" :class="{ selected: selectedFact === 'random' }">Random</v-btn>
							<v-btn class="fact-button mr-3" @click="selectFact('trivia')" :class="{ selected: selectedFact === 'trivia' }">Trivia</v-btn>
							<v-btn class="fact-button" @click="selectFact('year')" :class="{ selected: selectedFact === 'year' }">Year</v-btn>
						</v-row>
					</v-col>
				</v-row>
			</v-col>
		</v-row>
		<v-row justify="center" class="bottom-content pt-4" >
			<v-col cols="12" md="8">

				<v-row justify="center" v-if="selectedFact && selectedFact !== 'random'" style="width: 60%; margin: 0 auto;">
					<v-text-field v-model="inputValue" v-if="selectedFact === 'date'" type="text" placeholder="DD/MM"></v-text-field>
					<v-text-field v-model="inputValue" v-else type="number" placeholder="Enter a number"></v-text-field>
				</v-row>

				<v-row justify="center" class="fetch-button-container" :class="{ 'pt-6': selectedFact === 'random' }">
					<v-btn class="action-button" @click="fetchFact" v-if="selectedFact">Get Fact!</v-btn>
				</v-row>

				<v-row justify="center" style="width: 60%; margin: 0 auto;">
					<v-col cols="12" md="12">
						<div class="response-container">
							<div class="response" v-if="Object.keys(response).length > 0 && selectedFact === 'random'">{{ response.number }}</div>
							<div class="response" v-if="Object.keys(response).length > 0 && selectedFact === 'date'">{{ response.year }}</div>
							<div class="response" v-if="Object.keys(response).length > 0">{{ formatBlankText }}</div>
						</div>
					</v-col>
				</v-row>

				<v-row justify="center" v-if="Object.keys(response).length > 0" style="width: 60%; margin: 0 auto;">
					<v-col cols="12" md="8">
						<v-text-field v-model="guess" type="text" placeholder="Enter your guess"></v-text-field>
						<v-btn class="action-button" @click="submitGuess">Submit</v-btn>
					</v-col>
				</v-row>

				<v-row justify="center" class="show-result-container" style="width: 60%; margin: 0 auto;">
					<v-alert dense v-show="showResult" :type="result === 'correct' ? 'success' : 'error'" transition="scale-transition">
						{{ result === 'correct' ? 'Correct!' : 'Incorrect. Please try again.' }}
					</v-alert>
				</v-row>

				<v-row justify="center" style="width: 60%; margin: 0 auto;">
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
			guess: '',
			showResult: false,
			result: '',
			correctAnswer: '',
			blankText: ''
		};
	},
	methods: {
		goToRegister() {
			window.location.href = '/register';
		},
		goToLogin() {
			window.location.href = '/login';
		},
		selectFact(fact) {
			this.showError = false;
			if (this.selectedFact !== fact) {
				this.selectedFact = fact;
				this.showResult = false;
				this.inputValue = '';
				this.guess = '';
				this.response = {};
			}
		},
		isValidDate(dateString) {
			const dateRegex = /^\d{2}\/\d{2}$/;
			return dateRegex.test(dateString);
		},
		generateBlank(text) {
			console.log(text);
			// Split the text into an array of words and numbers
			let wordsAndNumbers = text.split(/\b/);
			console.log('first wordsAndNumbers', wordsAndNumbers)
			// Filter out empty strings and punctuation marks
			wordsAndNumbers = wordsAndNumbers.filter(item => /[a-zA-Z0-9]/.test(item));
			console.log('second wordsAndNumbers', wordsAndNumbers)

			// Randomly select one index to remove
			const indexToRemove = Math.floor(Math.random() * wordsAndNumbers.length);
			console.log('indexToRemove', indexToRemove)

			// Store the correct answer and its index before replacing it with a blank
			this.correctAnswer = wordsAndNumbers[indexToRemove];
			console.log('correctAnswer', this.correctAnswer)
			this.correctAnswerIndex = indexToRemove;
			console.log('this.correctAnswerIndex', this.correctAnswerIndex)

			// Replace the selected word or number with a blank
			wordsAndNumbers[indexToRemove] = '___';

			// Join the modified array into a string
			this.blankText = wordsAndNumbers.join('');
		},
		submitGuess() {
			// Check if the guess matches the correct answer
			console.log('correct', this.correctAnswer);

			if (this.guess.trim().toLowerCase() === this.correctAnswer.trim().toLowerCase()) {
				this.result = 'correct';
			} else {
				this.result = 'incorrect';
			}
			this.showResult = true;
		},
		async fetchFact() {
			this.showResult = false;
			this.guess = '';
			this.response = {};
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
					console.log('asdad', this.inputValue)
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
				this.blankText = this.generateBlank(this.response.text);
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
		},
		formatBlankText() {
			if (!this.response.text) return '';

			const textArray = this.response.text.split(' ');
			textArray[this.correctAnswerIndex] = '___';

			const formattedText = textArray.join(' ');
			return formattedText.charAt(0).toUpperCase() + formattedText.slice(1);
		}
	}
};
</script>
