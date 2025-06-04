<template>
	<section class="flex flex-col items-stretch justify-center w-full gap-8">
		<DataCreateForm
			:api-route="'/api/words'"
			:redirect-route-name="'words'"
			class="self-center">
			<template #header>Add word</template>
			<template #input-user_id="{ form }">
				<input
					type="hidden"
					name="user_id"
					class="input"
					autocomplete="off"
					v-model="form.user_id" />
			</template>
			<template #input-word_pack_id="{ form }">
				<select name="word_pack_id" class="input" v-model="form.word_pack_id">
					<option v-for="wordPack in wordPacks" :value="wordPack.id">
						{{ wordPack.name }}
					</option>
				</select>
			</template>
			<template #input-word="{ form }">
				<input
					type="text"
					name="word"
					class="input"
					autocomplete="off"
					v-model="form.word" />
			</template>
			<template #input-word_translation="{ form }">
				<input
					type="text"
					name="word_translation"
					class="input"
					autocomplete="off"
					v-model="form.word_translation" />
			</template>
			<template #input-example="{ form }">
				<input
					type="text"
					name="example"
					class="input"
					autocomplete="off"
					v-model="form.example" />
			</template>
			<template #input-example_translation="{ form }">
				<input
					type="text"
					name="example_translation"
					class="input"
					autocomplete="off"
					v-model="form.example_translation" />
			</template>
			<template #input-explanation="{ form }">
				<textarea
					name="explanation"
					class="input"
					autocomplete="off"
					v-model="form.explanation"></textarea>
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
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";

// Stores
const { user } = storeToRefs(useAuthStore());

// Lifecycle
onMounted(async () => {
	loadWordPacks();
});

// Variables
const wordPacks = ref([]);
const imageUploadInput = ref(null);

// Functions
async function loadWordPacks() {
	await handleRequest({
		request: () => axios.get("/api/word-packs/user"),
		successCallback: async (response) => {
			wordPacks.value = response.data;
		},
	});
}

function clearImageInput(form) {
	imageUploadInput.value.value = null;
	form.image = null;
}
</script>
