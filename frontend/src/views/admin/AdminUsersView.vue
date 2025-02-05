<template>
	<section class="flex flex-col flex-wrap max-w-full p-8 overflow-x-auto">
		<h1>Users</h1>

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
