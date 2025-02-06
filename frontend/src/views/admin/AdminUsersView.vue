<template>
	<section class="lg:p-8 flex flex-col max-w-full gap-4 p-4 overflow-x-auto">
		<h1 class="text-3xl font-bold">Users</h1>
		<div class="lg:flex-row lg:justify-between flex flex-col items-start gap-2">
			<button
				@click="console.log('new')"
				class="bg-secondary-300 hover:bg-secondary-200 px-4 py-2 font-bold text-gray-100 transition-colors rounded-md">
				New User
			</button>

			<input
				type="search"
				name="filter"
				placeholder="Search"
				class="input bg-secondary-300 placeholder:text-gray-100 focus:placeholder:text-opacity-0 sm:block hidden text-gray-100 border-0" />
		</div>

		<DataTable :data="users"></DataTable>
	</section>
</template>
<script setup>
import DataTable from "@/components/admin/DataTable.vue";
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
</script>
