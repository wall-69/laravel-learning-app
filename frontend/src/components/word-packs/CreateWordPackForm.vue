<template>
	<form
		class="bg-secondary-300 flex flex-col items-stretch max-w-sm gap-6 p-6 rounded-md"
		@submit.prevent="handleSubmit">
		<div class="flex flex-col items-center w-full">
			<h2 class="text-primary-300 md:text-7xl text-5xl leading-normal">
				Word pack
			</h2>
		</div>

		<!-- NAME -->
		<div class="flex flex-col">
			<label for="name" class="text-primary-100 font-bold">Name:</label>
			<input
				type="text"
				name="name"
				class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
				autocomplete="off"
				v-model="form.name" />

			<!-- Error -->
			<p v-show="errors.name" class="text-sm font-bold text-yellow-300">
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
				class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
				autocomplete="off"
				v-model="form.description" />

			<!-- Error -->
			<p v-show="errors.description" class="text-sm font-bold text-yellow-300">
				{{ errors.description }}
			</p>
		</div>

		<!-- VISIBILITY -->
		<div class="flex flex-col">
			<label for="description" class="text-primary-100 font-bold">
				Visibility:
			</label>
			<select
				name="visibility"
				class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
				v-model="form.visibility">
				<option value="public">Public</option>
				<option value="private">Private</option>
			</select>

			<!-- Error -->
			<p v-show="errors.visibility" class="text-sm font-bold text-yellow-300">
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
				class="md:min-w-40 bg-primary-100 border-primary-300 px-3 text-gray-700 border py-1.5 focus:outline-none rounded-md"
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
			<p v-show="errors.image" class="text-sm font-bold text-yellow-300">
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
	for (let k in errors) {
		errors[k] = "";
	}

	try {
		// TODO: move to separate file
		let formData = new FormData();
		formData.append("path_id", form.path_id ?? "");
		formData.append("name", form.name);
		formData.append("description", form.description);
		formData.append("type", form.type);
		formData.append("visibility", form.visibility);
		formData.append("image", form.image ?? "");

		let response = await axios.post("/api/word-packs", formData);

		router.replace({ name: "word-packs" });
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
