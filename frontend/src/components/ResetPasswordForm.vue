<template>
	<form
		class="bg-secondary-300 sm:rounded-md sm:w-auto flex flex-col w-full gap-6 p-6"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col items-center gap-2">
			<h2
				class="text-primary-300 md:text-7xl text-5xl leading-normal text-center">
				DailyVocab
			</h2>
		</div>

		<!-- PASSWORD -->
		<div class="flex flex-col">
			<label for="password" class="text-primary-100 text-sm font-bold">
				PASSWORD
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

		<!-- PASSWORD CONFIRMATION -->
		<div class="flex flex-col">
			<!-- PASSWORD CONFIRMATION -->
			<div class="flex flex-col">
				<label
					for="password_confirmation"
					class="text-primary-100 text-sm font-bold">
					CONFIRM PASSWORD
				</label>
				<input
					type="password"
					name="password_confirmation"
					class="input"
					v-model="form.password_confirmation" />
			</div>

			<!-- Error -->
			<p v-show="errors.password_confirmation" class="error-form">
				{{ errors.password_confirmation }}
			</p>
		</div>

		<!-- CHANGE PASSWORD BUTTON -->
		<button
			type="submit"
			class="btn-primary-cta self-center"
			:disabled="loading">
			CHANGE PASSWORD
		</button>
	</form>
</template>

<script setup>
import axios from "axios";
import { handleRequest } from "@/utils/requestWrapper";
import { reactive, ref, toRaw, watch, computed } from "vue";
import { useRoute } from "vue-router";
import router from "@/router";

// Composables
const route = useRoute();

// Variables
const loading = ref(false);

const form = reactive({
	token: route.params.token,
	email: route.query.email,
	password: "",
	password_confirmation: "",
});
const errors = reactive({
	password: "",
	password_confirmation: "",
});

// Functions
async function handleSubmit(e) {
	if (loading.value) {
		return;
	}

	loading.value = true;

	// Make request to the forgot password API endpoint
	await handleRequest({
		request: (data) => axios.post("/api/reset-password", data),
		requestData: form,
		successCallback: async (response) => {
			router.replace({ name: "login" });
		},
		errors: errors,
	});

	loading.value = false;
}
</script>
