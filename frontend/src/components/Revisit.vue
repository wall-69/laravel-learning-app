<template>
	<div class="bg-secondary-400 w-fit flex flex-col gap-3 p-4 pb-5 rounded-md">
		<div class="flex gap-1">
			<i>
				<box-icon
					name="customize"
					type="solid"
					color="#4DEDFF"
					size="lg"></box-icon>
			</i>
			<div class="flex flex-col">
				<h3 class="text-2xl text-gray-100">
					Revisit word packs from your vocabulary.
				</h3>
				<p class="text-gray-100">
					Feel free to review your word packs any time you want.
				</p>
			</div>
		</div>

		<div class="md:flex-row flex flex-col gap-4">
			<RouterLink
				v-if="!wordPacks || wordPacks.length == 0"
				class="text-primary-200">
				Click to add word packs to your vocabulary.
			</RouterLink>

			<template v-else>
				<RouterLink
					class="bg-primary-200 hover:bg-primary-300 flex flex-col items-center gap-2 p-3 pb-4 transition-colors rounded-md">
					<p class="underline">Word pack name</p>
					<img src="" alt="" class="w-[72px] h-[72px] object-cover" />
				</RouterLink>
				<RouterLink
					class="bg-primary-200 hover:bg-primary-300 flex flex-col items-center gap-2 p-3 pb-4 transition-colors rounded-md">
					<p class="underline">Word pack name</p>
					<img src="" alt="" class="w-[72px] h-[72px] object-cover" />
				</RouterLink>
				<RouterLink
					class="bg-primary-200 hover:bg-primary-300 flex flex-col items-center gap-2 p-3 pb-4 transition-colors rounded-md">
					<p class="underline">Word pack name</p>
					<img src="" alt="" class="w-[72px] h-[72px] object-cover" />
				</RouterLink>
			</template>
		</div>
	</div>
</template>

<script setup>
const props = defineProps({
	wordPacks: Array,
});
</script>
