<template>
	<form
		class="bg-secondary-300 flex flex-col gap-6 p-6 rounded-md"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col">
			<h2 class="text-primary-300 md:text-7xl text-5xl leading-normal">
				DailyVocab
			</h2>
			<p class="text-xl text-white">Sign up for your account today!</p>
		</div>

		<!-- NAME & SURNAME -->
		<div class="md:justify-between md:flex-row md:gap-10 flex flex-col gap-4">
			<!-- NAME -->
			<div class="flex flex-col">
				<label for="name" class="text-primary-100 text-sm font-bold">
					NAME
				</label>
				<input
					type="text"
					name="name"
					placeholder="John"
					class="input"
					v-model="form.name" />

				<!-- Error -->
				<p v-show="errors.name" class="error-form">
					{{ errors.name }}
				</p>
			</div>

			<!-- SURNAME -->
			<div class="flex flex-col">
				<label for="surname" class="text-primary-100 text-sm font-bold">
					SURNAME
				</label>
				<input
					type="text"
					name="surname"
					placeholder="Doe"
					class="input"
					v-model="form.surname" />

				<!-- Error -->
				<p v-show="errors.surname" class="error-form">
					{{ errors.surname }}
				</p>
			</div>
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

		<!-- PASSWORD & PASSWORD CONFIRMATION -->
		<div class="flex flex-col">
			<div class="md:justify-between md:flex-row md:gap-10 flex flex-col gap-4">
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
				</div>

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
			</div>

			<!-- Error -->
			<p
				v-show="errors.password || errors.password_confirmation"
				class="error-form">
				{{ errors.password ?? errors.password_confirmation }}
			</p>
		</div>

		<!-- TOS AGREE -->
		<div class="flex flex-col">
			<div class="flex gap-2">
				<input type="checkbox" class="input-checkbox" v-model="form.tos" />
				<label for="tos" class="text-primary-100 text-sm">
					I have read and agree to the
					<RouterLink
						:to="{ name: 'terms-of-service' }"
						class="hover:text-primary-300 underline">
						Terms of Service
					</RouterLink>
					and
					<RouterLink
						:to="{ name: 'privacy-policy' }"
						class="hover:text-primary-300 underline">
						Privacy Policy</RouterLink
					>.
				</label>
			</div>

			<!-- Error -->
			<p v-show="errors.tos" class="error-form">
				{{ errors.tos }}
			</p>
		</div>

		<!-- REGISTER BUTTON -->
		<button type="submit" class="btn-primary-cta self-center">REGISTER</button>

		<hr class="self-center w-2/3 h-0.5 bg-gray-200 rounded-md" />

		<p class="text-white">
			Already have an account?
			<RouterLink
				:to="{ name: 'login' }"
				class="hover:text-primary-300 font-bold underline">
				Login here.
			</RouterLink>
		</p>
	</form>
</template>

<script setup>
import useAuth from "@/composables/useAuth";
import router from "@/router";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { reactive, ref, toRaw, watch, computed } from "vue";
import { RouterLink } from "vue-router";

const { register } = useAuth();
const form = reactive({
	name: "",
	surname: "",
	email: "",
	password: "",
	password_confirmation: "",
	tos: false,
});
const errors = reactive({
	name: "",
	surname: "",
	email: "",
	password: "",
	password_confirmation: "",
	tos: "",
});

async function handleSubmit(e) {
	// Make request to the register API endpoint
	await handleRequest({
		request: register,
		requestData: form,
		successCallback: async (response) => {
			router.replace({ name: "login" });
		},
		errors: errors,
	});
}
</script>
