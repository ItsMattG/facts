<template>
	<v-container class="pt-12">
	  <v-row justify="center">
		<v-col cols="12" md="8">
		  <h2 class="text-center">Login</h2>
		  <v-form @submit.prevent="loginUser">
			<v-text-field
			  v-model="email"
			  label="Email Address"
			  type="email"
			  outlined
			  required
			></v-text-field>
			<v-text-field
			  v-model="password"
			  label="Password"
			  type="password"
			  outlined
			  required
			></v-text-field>
			<v-btn type="submit" color="primary">Login</v-btn>
		  </v-form>
		</v-col>
	  </v-row>
	</v-container>
  </template>

  <script>
  import axios from 'axios';

  export default {
	data() {
	  return {
		email: '',
		password: ''
	  };
	},
	methods: {
	  async loginUser() {
		try {
		  const response = await axios.post('api/login', {
			email: this.email,
			password: this.password
		  });
		  console.log(response.data);
		  // Handle success response
		} catch (error) {
		  console.error('Error logging in:', error);
		  // Handle error response
		}
	  }
	}
  };
  </script>
