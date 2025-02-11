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
			<template
				v-if="
					$route.name == 'admin-users-create' ||
					$route.name == 'admin-users-edit'
				">
				<RouterLink
					:to="{ name: 'admin-users' }"
					class="hover:underline font-bold text-gray-900 transition-colors rounded-md">
					Go back
				</RouterLink>
			</template>
		</div>

		<DataTable
			v-if="$route.name == 'admin-users'"
			:data="users"
			@update:data="users = $event"
			model-name="user"></DataTable>
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
			<template #input-surname="{ form }">
				<input
					type="text"
					name="surname"
					class="input"
					autocomplete="off"
					v-model="form.surname" />
			</template>
			<template #input-email="{ form }">
				<input
					type="email"
					name="email"
					class="input"
					autocomplete="off"
					v-model="form.email" />
			</template>
			<template #input-password="{ form }">
				<input
					type="password"
					name="password"
					class="input"
					autocomplete="off"
					v-model="form.password" />
			</template>
			<template #input-password_confirmation="{ form }">
				<input
					type="password"
					name="password_confirmation"
					class="input"
					autocomplete="off"
					v-model="form.password_confirmation" />
			</template>
		</DataCreateForm>
		<DataEditForm
			v-if="$route.name == 'admin-users-edit'"
			:api-route="'/api/users/' + $route.params.id"
			:redirect-route-name="'admin-users'"
			model-name="user"
			class="self-center">
			<template #header>Edit User</template>
			<template #input-name="{ form }">
				<input
					type="text"
					name="name"
					class="input"
					autocomplete="off"
					v-model="form.name" />
			</template>
			<template #input-surname="{ form }">
				<input
					type="text"
					name="surname"
					class="input"
					autocomplete="off"
					v-model="form.surname" />
			</template>
			<template #input-email="{ form }">
				<input
					type="email"
					name="email"
					class="input"
					autocomplete="off"
					v-model="form.email" />
			</template>
			<template #input-new_password="{ form }">
				<input
					type="password"
					name="new_password"
					class="input"
					autocomplete="off"
					v-model="form.new_password" />
			</template>
		</DataEditForm>
	</section>
</template>
<script setup>
import DataTable from "@/components/admin/DataTable.vue";
import DataCreateForm from "@/components/admin/DataCreateForm.vue";
import DataEditForm from "@/components/admin/DataEditForm.vue";
import { ref } from "vue";

// Variables
const users = ref({});
</script>
