<template>
	<form
		class="bg-secondary-300 flex flex-col items-stretch gap-6 p-6 rounded-md"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col items-center">
			<h2
				class="text-primary-300 md:text-6xl text-5xl leading-normal text-center">
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
			@disabled="loading"
			type="submit"
			class="bg-primary-200 hover:bg-primary-300 flex items-center self-center gap-2 px-4 py-2 text-xl font-bold transition-colors rounded-md">
			Create
		</button>
	</form>
</template>

<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import { ref, computed, reactive, watchEffect } from "vue";
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
const loading = ref(false);

// Computed
const inputSlots = computed(() => {
	return Object.keys(slots).filter((slot) => slot.startsWith("input-"));
});

// Functions
function slotNameToInputName(slotName) {
	return slotName.replace("input-", "");
}

async function handleSubmit() {
	if (loading.value) {
		return;
	}

	loading.value = true;

	let formData = new FormData();
	inputSlots.value.forEach((slotName) => {
		const inputName = slotNameToInputName(slotName);

		if (!form[inputName]) {
			return;
		}

		formData.append(inputName, form[inputName]);
	});

	await handleRequest({
		request: (data) => {
			return axios.post(props.apiRoute, data);
		},
		requestData: formData,
		successCallback: async (response) => {
			console.log(props.redirectRouteName);

			await router.replace({ name: props.redirectRouteName });
			loading.value = false;
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
