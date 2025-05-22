<template>
	<section
		class="lg:p-8 flex flex-col w-full max-w-full gap-4 p-4 overflow-x-auto">
		<h1 class="text-3xl font-bold">Admins</h1>

		<div class="lg:flex-row lg:justify-between flex flex-col items-start gap-2">
			<template v-if="$route.name == 'admin-admins'">
				<RouterLink
					:to="{ name: 'admin-admins-create' }"
					class="bg-secondary-300 hover:bg-secondary-200 px-4 py-2 font-bold text-gray-100 transition-colors rounded-md">
					New Admin
				</RouterLink>
			</template>
			<template
				v-if="
					$route.name == 'admin-admins-create' ||
					$route.name == 'admin-admins-edit'
				">
				<RouterLink
					:to="{ name: 'admin-admins' }"
					class="hover:underline font-bold text-gray-900 transition-colors rounded-md">
					Go back
				</RouterLink>
			</template>
		</div>

		<DataTable
			v-if="$route.name == 'admin-admins'"
			:data="admins"
			@update:data="admins = $event"
			model-name="admin"
			:edittable="false"></DataTable>
		<DataCreateForm
			v-if="$route.name == 'admin-admins-create'"
			:api-route="'/api/admins'"
			:redirect-route-name="'admin-admins'"
			class="self-center">
			<template #header>New Admin</template>
			<template #input-user_id="{ form }">
				<select name="user_id" class="input" v-model="form.user_id">
					<option v-for="user in users" :value="user.id">
						{{ user.name }} {{ user.surname }}
					</option>
				</select>
			</template>
		</DataCreateForm>
	</section>
</template>
<script setup>
import DataTable from "@/components/admin/DataTable.vue";
import DataCreateForm from "@/components/admin/DataCreateForm.vue";
import { onMounted, ref } from "vue";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";

// Lifecycle hooks
onMounted(async () => {
	loadUsers();
});

// Variables
const admins = ref({});
const users = ref({});

// Functions
async function loadUsers() {
	handleRequest({
		request: () => axios.get("/api/users"),
		successCallback: (response) => {
			users.value = response.data.data;
		},
	});
}
</script>
