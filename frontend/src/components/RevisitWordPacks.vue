<template>
	<div
		class="bg-secondary-300 flex flex-col flex-1 max-w-2xl gap-3 p-4 pb-5 rounded-md">
		<div class="flex gap-1">
			<i class="bx bxs-customize bx-lg text-primary-200"></i>
			<div class="flex flex-col">
				<h3 class="lg:text-2xl text-lg text-gray-100">
					Revisit word packs from your vocabulary.
				</h3>
				<p class="sm:block hidden text-gray-100">
					Feel free to review your word packs any time you want.
				</p>
			</div>
		</div>

		<button @click="addWordPack">add beginner wordpack</button>
		<div class="md:flex-row flex flex-col gap-4">
			<RouterLink
				v-if="!wordPacks || wordPacks.length == 0"
				class="text-primary-200 list-item list-disc list-inside">
				Add word packs to your vocabulary.
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
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";

// Define
const props = defineProps({
	wordPacks: Array,
});

// Functions
async function addWordPack() {
	await handleRequest({
		request: () => axios.post("/api/user/words/add/1"),
		successCallback: async (response) => {
			console.log(response);
		},
	});
}
</script>
