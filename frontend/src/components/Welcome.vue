<template>
	<div class="bg-secondary-400 w-fit flex flex-col gap-3 p-4 pb-5 rounded-md">
		<div class="flex gap-1">
			<i>
				<box-icon name="pin" type="solid" color="#4DEDFF" size="md"></box-icon>
			</i>
			<p class="text-2xl text-gray-100">Welcome back, Tomáš!</p>
		</div>

		<div class="md:flex-row flex flex-col gap-4">
			<RouterLink
				class="bg-primary-200 hover:bg-primary-300 flex items-center gap-2 px-3 py-1 text-lg transition-colors rounded-md">
				<i class="flex content-center">
					<box-icon name="customize" type="solid" color="#1B1B1"></box-icon>
				</i>
				Your word packs
			</RouterLink>
			<RouterLink
				class="bg-primary-200 hover:bg-primary-300 flex items-center gap-2 px-3 py-1 text-lg transition-colors rounded-md">
				<i class="flex content-center">
					<box-icon name="flag" color="#1B1B1"></box-icon>
				</i>
				Your paths
			</RouterLink>
			<RouterLink
				class="bg-primary-200 hover:bg-primary-300 flex items-center gap-2 px-3 py-1 text-lg transition-colors rounded-md">
				<i class="flex content-center">
					<box-icon name="spreadsheet" color="#1B1B1"></box-icon>
				</i>
				Read more
			</RouterLink>
		</div>
	</div>
</template>
<script setup>
import { RouterLink } from "vue-router";
</script>
