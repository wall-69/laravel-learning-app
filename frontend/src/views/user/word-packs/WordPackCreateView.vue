<template>
	<section class="flex flex-col items-stretch justify-center w-full gap-8">
		<DataCreateForm
			:api-route="'/api/word-packs'"
			:redirect-route-name="'user-word-packs'"
			:hidden-data="{
				type: 'community',
			}"
			class="self-center">
			<template #header>Create word pack</template>
			<template #input-name="{ form }">
				<input
					type="text"
					name="name"
					class="input"
					autocomplete="off"
					v-model="form.name" />
			</template>
			<template #input-description="{ form }">
				<textarea
					name="description"
					class="input"
					autocomplete="off"
					v-model="form.description"></textarea>
			</template>
			<template #input-visibility="{ form }">
				<select name="visibility" class="input" v-model="form.visibility">
					<option value="public">Public</option>
					<option value="private">Private</option>
				</select>
			</template>
			<template #input-image="{ form }">
				<input
					ref="imageUploadInput"
					type="file"
					accept="image/*"
					name="images"
					class="input"
					@change="(e) => (form.image = e.target.files[0])"
					@click="clearImageInput(form)" />
				<!-- Delete uploaded image button -->
				<button
					v-show="form.image"
					class="text-primary-100 self-start text-sm"
					@click.prevent="clearImageInput(form)">
					(Delete thumbnail)
				</button>
			</template>
		</DataCreateForm>
	</section>
</template>
<script setup>
import DataCreateForm from "@/components/admin/DataCreateForm.vue";
import router from "@/router";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref, watch, computed, reactive } from "vue";
import { asset } from "@/utils/asset";
import { useRoute } from "vue-router";

// Variables
const imageUploadInput = ref(null);

// Functions
function clearImageInput(form) {
	imageUploadInput.value.value = null;
	form.image = null;
}
</script>
