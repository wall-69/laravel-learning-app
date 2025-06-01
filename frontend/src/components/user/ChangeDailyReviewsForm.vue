<template>
	<form
		class="bg-secondary-300 sm:rounded-md sm:w-auto flex flex-col w-full gap-6 p-6"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col">
			<h3 class="text-primary-300 text-xl text-center">
				Change max daily reviews
			</h3>
		</div>

		<!-- DAILY REVIEWS -->
		<div class="flex flex-col">
			<label :for="form.setting" class="text-primary-100 text-sm font-bold">
				MAX DAILY REVIEWS
			</label>
			<input
				type="number"
				:name="form.setting"
				class="input"
				v-model="form.value"
				min="1"
				max="999" />
			<!-- Error -->
			<p v-show="errors.setting" class="error-form">
				{{ errors.setting }}
			</p>

			<p v-show="errors.value" class="error-form">
				{{ errors.value }}
			</p>
		</div>

		<!-- CHANGE BUTTON -->
		<button type="submit" class="btn-primary self-center" :disabled="loading">
			Change
		</button>
	</form>
</template>
<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import { reactive, ref } from "vue";
import axios from "axios";
import router from "@/router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";

// Stores
const { user } = storeToRefs(useAuthStore());

// Variables
const loading = ref(false);

const form = reactive({
	setting: "daily_reviews",
	value: user.value.user_settings?.settings?.daily_reviews ?? 25,
});
const errors = reactive({
	setting: "",
	value: "",
});

// Functions
async function handleSubmit() {
	const agreed = confirm(
		"Are you sure you want to set your daily reviews to " + form.value + "?"
	);
	if (!agreed) return;

	loading.value = true;

	await handleRequest({
		request: (data) => axios.post("/api/user/settings/set", data),
		requestData: form,
		successCallback: async (response) => {
			user.value.user_settings.settings["daily_reviews"] = form.value;
		},
		errors: errors,
	});

	loading.value = false;
}
</script>
