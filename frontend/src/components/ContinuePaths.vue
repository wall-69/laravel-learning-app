<template>
	<div
		class="bg-secondary-300 flex flex-col flex-1 max-w-2xl gap-3 p-4 pb-5 rounded-md">
		<div class="flex gap-1">
			<i>
				<box-icon name="flag" type="solid" color="#4DEDFF" size="lg"></box-icon>
			</i>
			<div class="flex flex-col">
				<h3 class="lg:text-2xl text-lg text-gray-100">
					Continue in your learning paths.
				</h3>
				<p class="lg:block hidden text-gray-100">
					Enlarge your vocabulary using learning paths with increasing
					difficulty.
				</p>
			</div>
		</div>

		<div class="md:flex-row flex flex-col gap-4">
			<RouterLink
				v-if="!paths || paths.length == 0"
				class="text-primary-200 list-item list-disc list-inside">
				Add paths.
			</RouterLink>

			<template v-else>
				<RouterLink
					class="bg-primary-200 hover:bg-primary-300 flex flex-col items-center gap-2 p-3 pb-4 transition-colors rounded-md">
					<p class="underline">Path name</p>
					<img src="" alt="" class="w-[72px] h-[72px] object-cover" />
				</RouterLink>
				<RouterLink
					class="bg-primary-200 hover:bg-primary-300 flex flex-col items-center gap-2 p-3 pb-4 transition-colors rounded-md">
					<p class="underline">Path name</p>
					<img src="" alt="" class="w-[72px] h-[72px] object-cover" />
				</RouterLink>
				<RouterLink
					class="bg-primary-200 hover:bg-primary-300 flex flex-col items-center gap-2 p-3 pb-4 transition-colors rounded-md">
					<p class="underline">Path name</p>
					<img src="" alt="" class="w-[72px] h-[72px] object-cover" />
				</RouterLink>
			</template>
		</div>
	</div>
</template>

<script setup>
// Define
const props = defineProps({
	paths: Array,
});
</script>
