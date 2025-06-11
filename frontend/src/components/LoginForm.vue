<template>
	<form
		class="bg-secondary-300 sm:rounded-md sm:w-auto flex flex-col w-full gap-6 p-6"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col">
			<h2
				class="text-primary-300 md:text-7xl text-5xl leading-normal text-center">
				DailyVocab
			</h2>
		</div>

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

		<!-- LOGIN BUTTON -->
		<button
			type="submit"
			class="btn-primary-cta self-center"
			:disabled="loading">
			LOGIN
		</button>

		<hr class="self-center w-2/3 h-0.5 bg-gray-200 rounded-md" />

		<p class="text-white">
			<RouterLink
				:to="{ name: 'forgot-password' }"
				class="hover:text-primary-300 font-bold underline">
				Forgot your password?
			</RouterLink>
		</p>
		<p class="text-white">
			Don't have an account yet?
			<RouterLink
				:to="{ name: 'register' }"
				class="hover:text-primary-300 font-bold underline">
				Register here.
			</RouterLink>
		</p>
	</form>
</template>

<script setup>
import router from "@/router";
import useAuth from "@/composables/useAuth";
import { handleRequest } from "@/utils/requestWrapper";
import { reactive, ref, watch, computed } from "vue";
import { RouterLink } from "vue-router";

// Composables
const { login } = useAuth();

// Variables
const loading = ref(false);

const form = reactive({
	email: "",
	password: "",
});
const errors = reactive({
	email: "",
	password: "",
});

// Functions
async function handleSubmit(e) {
	if (loading.value) {
		return;
	}

	loading.value = true;

	// Make request to the login API endpoint
	await login(form, errors);

	loading.value = false;
}
</script>
