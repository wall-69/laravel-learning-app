<template>
	<form
		class="bg-secondary-300 flex flex-col items-stretch max-w-sm gap-6 p-6 rounded-md"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col items-center w-full">
			<h2 class="text-primary-300 md:text-6xl text-5xl leading-normal">
				<slot name="header"></slot>
			</h2>
		</div>

		<div v-for="slotName in inputSlots" :key="slotName" class="flex flex-col">
			<label
				:for="slotNameToInputName(slotName)"
				class="text-primary-100 font-bold">
				{{
					slotNameToInputName(slotName).charAt(0).toUpperCase() +
					slotNameToInputName(slotName).slice(1).replace("_", " ")
				}}:
			</label>
			<slot :name="slotName" :form="form"></slot>
			<!-- Error -->
			<p v-show="errors[slotNameToInputName(slotName)]" class="error-form">
				{{ errors[slotNameToInputName(slotName)] }}
			</p>
		</div>

		<!-- CREATE BUTTON -->
		<button
			type="submit"
			class="bg-primary-200 hover:bg-primary-300 flex items-center self-center gap-2 px-4 py-2 text-xl font-bold transition-colors rounded-md">
			Create
		</button>
	</form>
</template>

<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import { computed, reactive, watchEffect } from "vue";
import axios from "axios";
import router from "@/router";
import { useSlots } from "vue";

// Composables
const slots = useSlots();

// Define
const props = defineProps({
	apiRoute: String,
	redirectRouteName: String,
});

// Variables
const form = reactive({});
const errors = reactive({});

// Computed
const inputSlots = computed(() => {
	return Object.keys(slots).filter((slot) => slot.startsWith("input-"));
});

// Functions
function slotNameToInputName(slotName) {
	return slotName.replace("input-", "");
}

async function handleSubmit(e) {
	let formData = new FormData();
	Object.keys(slots).forEach((slotName) => {
		const inputName = slotNameToInputName(slotName);

		formData.append(inputName, form[inputName]);
	});

	await handleRequest({
		request: (data) => {
			return axios.post(props.apiRoute, data);
		},
		requestData: formData,
		successCallback: async (response) => {
			await router.replace({ name: props.redirectRouteName });
		},
		errors: errors,
	});
}

// Watchers
watchEffect(() => {
	inputSlots.value.forEach((slotName) => {
		const inputName = slotNameToInputName(slotName);
		if (!(inputName in form)) {
			form[inputName] = "";
		}
		if (!(inputName in errors)) {
			errors[inputName] = "";
		}
	});
});
</script>
