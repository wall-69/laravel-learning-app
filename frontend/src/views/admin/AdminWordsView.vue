<template>
	<section
		class="lg:p-8 flex flex-col w-full max-w-full gap-4 p-4 overflow-x-auto">
		<h1 class="text-3xl font-bold">Words</h1>

		<div class="lg:flex-row lg:justify-between flex flex-col items-start gap-2">
			<template v-if="$route.name == 'admin-words'">
				<RouterLink
					:to="{ name: 'admin-words-create' }"
					class="bg-secondary-300 hover:bg-secondary-200 px-4 py-2 font-bold text-gray-100 transition-colors rounded-md">
					New Word
				</RouterLink>

				<form @submit.prevent="search = searchInput.value">
					<input
						ref="searchInput"
						type="search"
						name="search"
						placeholder="Search"
						class="input bg-secondary-300 placeholder:text-gray-100 focus:placeholder:text-opacity-0 sm:block hidden text-gray-100 border-0" />
				</form>
			</template>
			<template
				v-if="
					$route.name == 'admin-words-create' ||
					$route.name == 'admin-words-edit'
				">
				<RouterLink
					:to="{ name: 'admin-words' }"
					class="hover:underline font-bold text-gray-900 transition-colors rounded-md">
					Go back
				</RouterLink>
			</template>
		</div>

		<DataTable
			v-if="$route.name == 'admin-words'"
			:data="words"
			@update:data="words = $event"
			model-name="word"
			:search="search"></DataTable>
		<DataCreateForm
			v-if="$route.name == 'admin-words-create'"
			:api-route="'/api/words'"
			:redirect-route-name="'admin-words'"
			class="self-center">
			<template #header>New Word</template>
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
		<DataEditForm
			v-if="$route.name == 'admin-words-edit'"
			:api-route="'/api/words/' + $route.params.id"
			:redirect-route-name="'admin-words'"
			model-name="word"
			class="self-center">
			<template #header>Edit Word</template>
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
				<img
					v-show="form.image && String(form.image).startsWith('storage')"
					:src="asset(form.image)"
					class="w-16 mb-2" />
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
		</DataEditForm>
	</section>
</template>
<script setup>
import DataTable from "@/components/admin/DataTable.vue";
import DataCreateForm from "@/components/admin/DataCreateForm.vue";
import DataEditForm from "@/components/admin/DataEditForm.vue";
import { ref } from "vue";
import { asset } from "@/utils/asset";

// Variables
const words = ref({});
const search = ref("");
const searchInput = ref(null);
const imageUploadInput = ref(null);

// Functions
function clearImageInput(form) {
	imageUploadInput.value.value = null;
	form.image = null;
}
</script>
