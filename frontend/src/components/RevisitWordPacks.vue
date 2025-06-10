<template>
	<div class="bg-secondary-300 flex flex-col flex-1 gap-3 p-4 pb-5 rounded-md">
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

		<div
			class="flex-nowrap flex gap-4 overflow-x-scroll"
			:class="{
				'h-64': wordPacks.length > 0,
			}">
			<RouterLink
				v-if="!wordPacks || wordPacks.length == 0"
				class="text-primary-200 list-item list-disc list-inside">
				Add word packs to your vocabulary.
			</RouterLink>

			<template v-else>
				<RouterLink
					v-for="wordPack in wordPacks"
					class="hover:bg-gray-50 md:w-52 flex flex-col items-center w-full gap-2 p-3 transition-colors bg-white rounded-md">
					<h6
						class="text-primary-400 px-1 mb-2 text-lg font-bold text-center rounded-md">
						{{ wordPack.name }}
					</h6>
					<img
						v-if="wordPack.image"
						:src="asset(wordPack.image)"
						alt=""
						class="object-cover w-48 h-48 rounded-md" />
					<p v-else class="max-w-48 my-auto text-sm text-center break-words">
						{{ wordPack.description }}
					</p>
				</RouterLink>
			</template>
		</div>
	</div>
</template>

<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref } from "vue";
import { asset } from "@/utils/asset";

// Lifecycle
onMounted(async () => {
	await loadWordPacks();
});

// Variables
const wordPacks = ref([]);

// Functions
async function loadWordPacks() {
	await handleRequest({
		request: () => axios.get("/api/user/word-packs"),
		successCallback: async (response) => {
			wordPacks.value = response.data.data;
		},
	});
}
</script>
