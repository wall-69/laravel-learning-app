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
					class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
					v-model="form.name" />

				<!-- Error -->
				<p v-show="errors.name" class="text-sm font-bold text-yellow-300">
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
					class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
					v-model="form.surname" />

				<!-- Error -->
				<p v-show="errors.surname" class="text-sm font-bold text-yellow-300">
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
				class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
				v-model="form.email" />

			<!-- Error -->
			<p v-show="errors.email" class="text-sm font-bold text-yellow-300">
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
						class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
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
						class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
						v-model="form.password_confirmation" />
				</div>
			</div>

			<!-- Error -->
			<p
				v-show="errors.password || errors.password_confirmation"
				class="text-sm font-bold text-yellow-300">
				{{ errors.password ?? errors.password_confirmation }}
			</p>
		</div>

		<!-- TOS AGREE -->
		<div class="flex flex-col">
			<div class="flex gap-2">
				<input
					type="checkbox"
					class="accent-primary-100 w-6"
					v-model="form.tos" />
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
			<p v-show="errors.tos" class="text-sm font-bold text-yellow-300">
				{{ errors.tos }}
			</p>
		</div>

		<!-- REGISTER BUTTON -->
		<button type="submit" class="btn-register-primary self-center">
			REGISTER
		</button>

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
import axios from "axios";
import { reactive, ref, toRaw, watch, computed } from "vue";
import { RouterLink } from "vue-router";

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
	for (let k in errors) {
		errors[k] = "";
	}

	try {
		let response = await axios.post("/api/users", form);
	} catch (e) {
		if (e.response) {
			Object.keys(e.response.data.errors).forEach((field) => {
				errors[field] = e.response.data.errors[field][0];
			});
		}
	}
}
</script>
