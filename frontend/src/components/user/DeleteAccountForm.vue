<template>
	<form
		class="bg-secondary-300 sm:rounded-md sm:w-auto flex flex-col w-full gap-6 p-6"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col">
			<h3 class="text-primary-300 text-xl text-center">Delete account</h3>
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

		<!-- DELETE ACCOUNT BUTTON -->
		<button type="submit" class="btn-primary self-center" :disabled="loading">
			Delete account
		</button>
	</form>
</template>
<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import { reactive, ref } from "vue";
import axios from "axios";
import router from "@/router";
import useAuth from "@/composables/useAuth";

// Composables
const { user, setUser, setAuthenticated } = useAuth();

// Variables
const loading = ref(false);

const form = reactive({
	password: "",
	_method: "DELETE",
});
const errors = reactive({
	password: "",
});

// Functions
async function handleSubmit() {
	loading.value = true;

	confirm("Are you sure you want to delete your account?");

	await handleRequest({
		request: (data) => axios.post("/api/users/" + user.value.id, data),
		requestData: form,
		successCallback: async (response) => {
			setUser({});
			setAuthenticated(false);

			await router.replace({ name: "home" });
		},
		failCallback: async (response) => {
			console.error("Could not delete account.", response);
		},
		errors: errors,
	});

	loading.value = false;
}
</script>
