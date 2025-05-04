<template>
	<form
		class="bg-secondary-300 sm:rounded-md sm:w-auto flex flex-col w-full gap-6 p-6"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col items-center gap-2">
			<h2
				class="text-primary-300 md:text-7xl text-5xl leading-normal text-center">
				DailyVocab
			</h2>

			<p class="text-primary-400 md:text-sm max-w-sm text-base text-center">
				Put your email address in the field below, then click RESET PASSWORD. An
				email will be sent to you with instructions for resetting your password.
			</p>
		</div>

		<template v-if="!sent">
			<!-- EMAIL -->
			<div class="flex flex-col">
				<label for="email" class="text-primary-100 text-sm font-bold">
					EMAIL
				</label>
				<input
					type="email"
					name="email"
					placeholder="john@doe.com"
					class="input"
					v-model="form.email" />

				<!-- Error -->
				<p v-show="errors.email" class="error-form">
					{{ errors.email }}
				</p>
			</div>

			<!-- RESET PASSWORD BUTTON -->
			<button
				type="submit"
				class="btn-primary-cta self-center"
				:disabled="loading">
				RESET PASSWORD
			</button>
		</template>
		<template v-else>
			<p class="text-lg">
				An email was sent to your email address. (Check your SPAM folder.)
			</p>
		</template>

		<hr class="self-center w-2/3 h-0.5 bg-gray-200 rounded-md" />

		<p class="text-white">
			<RouterLink
				:to="{ name: 'register' }"
				class="hover:text-primary-300 font-bold underline">
				Don't have an account?
			</RouterLink>
		</p>
	</form>
</template>

<script setup>
import axios from "axios";
import { handleRequest } from "@/utils/requestWrapper";
import { reactive, ref, toRaw, watch, computed } from "vue";
import { RouterLink } from "vue-router";

// Variables
const loading = ref(false);
const sent = ref(false);

const form = reactive({
	email: "",
});
const errors = reactive({
	email: "",
});

// Functions
async function handleSubmit(e) {
	if (loading.value) {
		return;
	}

	loading.value = true;

	// Make request to the forgot password API endpoint
	await handleRequest({
		request: (data) => axios.post("/api/forgot-password", data),
		requestData: form,
		errors: errors,
	});

	loading.value = false;
}
</script>
