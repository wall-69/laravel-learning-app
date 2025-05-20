<template>
	<form
		class="bg-secondary-300 sm:rounded-md sm:w-auto flex flex-col w-full gap-6 p-6"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col">
			<h3 class="text-primary-300 text-xl text-center">Change password</h3>
		</div>

		<!-- NEW PASSWORD -->
		<div class="flex flex-col">
			<label for="password" class="text-primary-100 text-sm font-bold">
				NEW PASSWORD
			</label>
			<input
				type="password"
				name="password"
				class="input"
				v-model="form.new_password" />

			<!-- Error -->
			<p v-show="errors.new_password" class="error-form">
				{{ errors.new_password }}
			</p>
		</div>

		<!-- NEW PASSWORD CONFIRMATION -->
		<div class="flex flex-col">
			<label
				for="password_confirmation"
				class="text-primary-100 text-sm font-bold">
				CONFIRM NEW PASSWORD
			</label>
			<input
				type="password"
				name="password_confirmation"
				class="input"
				v-model="form.new_password_confirmation" />

			<!-- Error -->
			<p v-show="errors.new_password_confirmation" class="error-form">
				{{ errors.new_password_confirmation }}
			</p>
		</div>

		<!-- PASSWORD -->
		<div class="flex flex-col">
			<label for="password" class="text-primary-100 text-sm font-bold">
				CURRENT PASSWORD
			</label>
			<input
				type="password"
				name="password"
				class="input"
				v-model="form.password" />

			<!-- Error -->
			<p v-show="errors.password" class="error-form">
				{{ errors.password }}
			</p>
		</div>

		<!-- CHANGE PASSWORD BUTTON -->
		<button type="submit" class="btn-primary self-center" :disabled="loading">
			Change password
		</button>
	</form>
</template>
<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import { reactive, ref } from "vue";
import axios from "axios";

// Variables
const loading = ref(false);

const form = reactive({
	password: "",
	new_password: "",
	new_password_confirmation: "",
});
const errors = reactive({
	password: "",
	new_password: "",
	new_password_confirmation: "",
});

// Functions
async function handleSubmit() {
	loading.value = true;

	await handleRequest({
		request: (data) => axios.post("/api/user/change-password", data),
		requestData: form,
		successCallback: async (response) => {
			// Clear the values and errors
			for (let k in form) {
				form[k] = "";
				errors[k] = "";
			}
		},
		failCallback: async (response) => {
			console.error("Could not change password.", response);
		},
		errors: errors,
	});

	loading.value = false;
}
</script>
