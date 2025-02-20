<template>
	<section
		class="lg:p-8 flex flex-col w-full max-w-full gap-4 p-4 overflow-x-auto">
		<h1 class="text-3xl font-bold">Word packs</h1>

		<div class="lg:flex-row lg:justify-between flex flex-col items-start gap-2">
			<template v-if="$route.name == 'admin-word-packs'">
				<RouterLink
					:to="{ name: 'admin-word-packs-create' }"
					class="bg-secondary-300 hover:bg-secondary-200 px-4 py-2 font-bold text-gray-100 transition-colors rounded-md">
					New Word pack
				</RouterLink>

				<input
					type="search"
					name="filter"
					placeholder="Search"
					class="input bg-secondary-300 placeholder:text-gray-100 focus:placeholder:text-opacity-0 sm:block hidden text-gray-100 border-0" />
			</template>
			<template
				v-if="
					$route.name == 'admin-word-packs-create' ||
					$route.name == 'admin-word-packs-edit'
				">
				<RouterLink
					:to="{ name: 'admin-word-packs' }"
					class="hover:underline font-bold text-gray-900 transition-colors rounded-md">
					Go back
				</RouterLink>
			</template>
		</div>

		<DataTable
			v-if="$route.name == 'admin-word-packs'"
			:data="wordPacks"
			@update:data="wordPacks = $event"
			model-name="word-pack"></DataTable>
		<DataCreateForm
			v-if="$route.name == 'admin-word-packs-create'"
			:api-route="'/api/word-packs'"
			:redirect-route-name="'admin-word-packs'"
			class="self-center">
			<template #header>New Word pack</template>
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
		<DataEditForm
			v-if="$route.name == 'admin-word-packs-edit'"
			:api-route="'/api/word-packs/' + $route.params.id"
			:redirect-route-name="'admin-word-packs'"
			model-name="word-pack"
			class="self-center">
			<template #header>Edit Word pack</template>
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
const wordPacks = ref({});
const imageUploadInput = ref(null);

// Functions
function clearImageInput(form) {
	imageUploadInput.value.value = null;
	form.image = null;
}
</script>
