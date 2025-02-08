<template>
	<section
		class="lg:p-8 flex flex-col w-full max-w-full gap-4 p-4 overflow-x-auto">
		<h1 class="text-3xl font-bold">Users</h1>
		<div class="lg:flex-row lg:justify-between flex flex-col items-start gap-2">
			<template v-if="$route.name == 'admin-users'">
				<RouterLink
					:to="{ name: 'admin-users-create' }"
					class="bg-secondary-300 hover:bg-secondary-200 px-4 py-2 font-bold text-gray-100 transition-colors rounded-md">
					New User
				</RouterLink>

				<input
					type="search"
					name="filter"
					placeholder="Search"
					class="input bg-secondary-300 placeholder:text-gray-100 focus:placeholder:text-opacity-0 sm:block hidden text-gray-100 border-0" />
			</template>
			<template v-if="$route.name == 'admin-users-create'">
				<RouterLink
					:to="{ name: 'admin-users' }"
					class="hover:underline font-bold text-gray-900 transition-colors rounded-md">
					Go back
				</RouterLink>
			</template>
		</div>

		<DataTable v-if="$route.name == 'admin-users'" :data="users"></DataTable>
		<DataCreateForm
			v-if="$route.name == 'admin-users-create'"
			:api-route="'/api/users'"
			:redirect-route-name="'admin-users'"
			class="self-center">
			<template #header>New User</template>
			<template #input-name="{ form }">
				<input
					type="text"
					name="name"
					class="input"
					autocomplete="off"
					v-model="form.name" />
			</template>
			<template #input-description="{ form }">
				<input
					type="text"
					name="description"
					class="input"
					autocomplete="off"
					v-model="form.description" />
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
					@click="clearUploadedImage(form)" />
				<!-- Delete uploaded image button -->
				<button
					v-show="form.image"
					class="text-primary-100 self-start text-sm"
					@click.prevent="clearUploadedImage(form)">
					(Delete thumbnail)
				</button>
			</template>
		</DataCreateForm>
	</section>
</template>
<script setup>
import DataTable from "@/components/admin/DataTable.vue";
import DataCreateForm from "@/components/admin/DataCreateForm.vue";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref } from "vue";

const users = ref({});

onMounted(async () => {
	await handleRequest({
		request: () => axios.get("/api/users"),
		successCallback: async (response) => {
			users.value = response.data.users;
		},
		failCallback: async (response) => {
			console.error("Could not load users from the database.", response);
		},
	});
});

// Create form
const imageUploadInput = ref(null);

function clearUploadedImage(form) {
	imageUploadInput.value.value = "";
	form.image = "";
}
</script>
