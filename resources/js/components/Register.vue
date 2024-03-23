<template>
	<v-container class="pt-12">
	  <v-row justify="center">
		<v-col cols="12" md="8">
		  <h2 class="text-center">Register</h2>
		  <v-form @submit.prevent="registerUser">
			<v-text-field
			  v-model="username"
			  label="Username"
			  outlined
			  required
			></v-text-field>
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
			<v-btn type="submit" color="primary">Register</v-btn>
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
		username: '',
		email: '',
		password: ''
	  };
	},
	methods: {
	  async registerUser() {
		try {
		  const response = await axios.post('api/register', {
			username: this.username,
			email: this.email,
			password: this.password
		  });
		  console.log(response.data);
		  // Handle success response
		} catch (error) {
		  console.error('Error registering user:', error);
		  // Handle error response
		}
	  }
	}
  };
  </script>
