<template>
	<div class="bg-secondary-400 flex flex-col flex-1 gap-3 p-4 pb-5 rounded-md">
		<div class="flex gap-1">
			<i class="bx bxs-pin bx-md text-primary-200 flex"></i>
			<p class="text-2xl text-gray-100">Welcome back, {{ user.name }}!</p>
		</div>

		<div class="md:flex-row flex flex-col flex-wrap gap-4">
			<RouterLink :to="{ name: 'user-word-packs' }" class="btn-primary">
				<i class="bx bxs-customize bx-sm flex text-gray-900"></i>
				Your word packs
			</RouterLink>
			<RouterLink to="" class="btn-primary">
				<i class="bx bxs-flag bx-sm flex text-gray-900"></i>
				Your paths
			</RouterLink>
			<RouterLink to="" class="btn-primary">
				<i class="bx bxs-spreadsheet bx-sm flex text-gray-900"></i>
				Read more
			</RouterLink>
		</div>
	</div>
</template>

<script setup>
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { RouterLink } from "vue-router";

// Stores
const { user } = storeToRefs(useAuthStore());
</script>
