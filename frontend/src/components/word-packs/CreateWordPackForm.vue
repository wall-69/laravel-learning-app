<template>
	<form
		class="bg-secondary-300 flex flex-col items-stretch max-w-sm gap-6 p-6 rounded-md"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col items-center w-full">
			<h2 class="text-primary-300 md:text-6xl text-5xl leading-normal">
				Word pack
			</h2>
		</div>

		<!-- NAME -->
		<div class="flex flex-col">
			<label for="name" class="text-primary-100 font-bold">Name:</label>
			<input
				type="text"
				name="name"
				class="input"
				autocomplete="off"
				v-model="form.name" />

			<!-- Error -->
			<p v-show="errors.name" class="error-form">
				{{ errors.name }}
			</p>
		</div>

		<!-- DESCRIPTION -->
		<div class="flex flex-col">
			<label for="description" class="text-primary-100 font-bold">
				Description:
			</label>
			<input
				type="text"
				name="description"
				class="input"
				autocomplete="off"
				v-model="form.description" />

			<!-- Error -->
			<p v-show="errors.description" class="error-form">
				{{ errors.description }}
			</p>
		</div>

		<!-- VISIBILITY -->
		<div class="flex flex-col">
			<label for="description" class="text-primary-100 font-bold">
				Visibility:
			</label>
			<select name="visibility" class="input" v-model="form.visibility">
				<option value="public">Public</option>
				<option value="private">Private</option>
			</select>

			<!-- Error -->
			<p v-show="errors.visibility" class="error-form">
				{{ errors.visibility }}
			</p>
		</div>

		<!-- IMAGE -->
		<div class="flex flex-col">
			<label for="description" class="text-primary-100 font-bold">
				Thumbnail:
			</label>
			<input
				ref="imageUploadInput"
				type="file"
				accept="image/*"
				name="images"
				class="input"
				@change="(e) => (form.image = e.target.files[0])"
				@click="clearUploadedImage" />
			<!-- Delete uploaded image button -->
			<button
				v-show="form.image"
				class="text-primary-100 self-start text-sm"
				@click.prevent="clearUploadedImage">
				(Delete thumbnail)
			</button>

			<!-- Error -->
			<p v-show="errors.image" class="error-form">
				{{ errors.image }}
			</p>
		</div>

		<!-- LOGIN BUTTON -->
		<button
			type="submit"
			class="bg-primary-200 hover:bg-primary-300 flex items-center self-center gap-2 px-4 py-2 text-xl font-bold transition-colors rounded-md">
			Create
		</button>
	</form>
</template>

<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import { reactive, ref } from "vue";
import axios from "axios";
import router from "@/router";

const imageUploadInput = ref(null);

function clearUploadedImage() {
	imageUploadInput.value.value = "";
	form.image = "";
}

const form = reactive({
	path_id: null,
	name: "",
	description: "",
	type: "",
	visibility: "",
	image: "",
});
const errors = reactive({
	path_id: "",
	name: "",
	description: "",
	type: "",
	visibility: "",
	image: "",
});

async function handleSubmit(e) {
	let formData = new FormData();
	formData.append("path_id", form.path_id ?? "");
	formData.append("name", form.name);
	formData.append("description", form.description);
	formData.append("type", form.type);
	formData.append("visibility", form.visibility);
	formData.append("image", form.image ?? "");

	await handleRequest({
		request: (data) => {
			return axios.post("/api/word-packs", data);
		},
		requestData: formData,
		successCallback: async (response) => {
			router.replace({ name: "word-packs" });
		},
		errors: errors,
	});
}
</script>
