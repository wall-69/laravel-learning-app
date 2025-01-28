<template>
	<form
		class="bg-secondary-300 flex flex-col gap-6 p-6 rounded-md"
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
				class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
				v-model="form.email" />

			<!-- Error -->
			<p v-show="errors.email" class="text-sm font-bold text-yellow-300">
				{{ errors.email }}
			</p>
		</div>

		<!-- PASSWORD -->
		<div class="flex flex-col">
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

			<!-- Error -->
			<p v-show="errors.password" class="text-sm font-bold text-yellow-300">
				{{ errors.password }}
			</p>
		</div>

		<!-- LOGIN BUTTON -->
		<button type="submit" class="btn-primary self-center">LOGIN</button>

		<hr class="self-center w-2/3 h-0.5 bg-gray-200 rounded-md" />

		<p class="text-white">
			<RouterLink
				:to="{ name: 'forgot-password' }"
				class="hover:text-primary-300 font-bold underline">
				Forgot your password?
			</RouterLink>
		</p>
	</form>
</template>

<script setup>
import useAuth from "@/composables/useAuth";
import axios from "axios";
import { reactive, ref, toRaw, watch, computed } from "vue";
import { RouterLink } from "vue-router";

const { login } = useAuth();

const form = reactive({
	email: "",
	password: "",
});
const errors = reactive({
	email: "",
	password: "",
});

async function handleSubmit(e) {
	for (let k in errors) {
		errors[k] = "";
	}

	try {
		await login(form);
	} catch (ex) {
		if (!ex.response) {
			return;
		}

		Object.keys(ex.response.data.errors).forEach((field) => {
			errors[field] = ex.response.data.errors[field][0];
		});
	}
}
</script>
