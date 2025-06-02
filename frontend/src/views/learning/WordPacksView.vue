<template>
	<section class="flex flex-col w-full gap-8">
		<h1 class="text-4xl font-bold text-center text-gray-900">Word packs</h1>

		<div class="flex flex-col gap-8">
			<!-- Tools bar -->
			<div class="flex justify-end">
				<form class="self-end" @submit.prevent="search = searchInput.value">
					<input
						ref="searchInput"
						type="search"
						name="search"
						placeholder="Search"
						class="input bg-secondary-300 placeholder:text-gray-100 focus:placeholder:text-opacity-0 sm:block hidden text-gray-100 border-0" />
				</form>
			</div>

			<!-- Show word packs -->
			<div
				class="bg-secondary-300 text-secondary-content-300 flex flex-col gap-4 p-4 rounded-md">
				<template v-if="loading">
					<p class="text-xl text-center">Loading...</p>
				</template>

				<!-- No word packs to show -->
				<div v-else-if="wordPacks.length == 0">
					<p class="text-xl text-center">No word packs were found.</p>
				</div>

				<!-- Word packs -->
				<div v-else class="md:flex-row flex flex-col gap-4">
					<div
						v-for="wordPack in wordPacks"
						v-hover-no-document-scroll
						@click="wordPackModal.openWordPackModal(wordPack.id)"
						class="hover:bg-gray-50 min-w-fit hover:cursor-pointer flex flex-col items-center h-64 gap-2 p-3 overflow-y-scroll transition-colors bg-white rounded-md">
						<h6
							class="text-primary-400 px-1 mb-2 text-lg font-bold text-center rounded-md">
							{{ wordPack.name }}
						</h6>
						<img
							v-if="wordPack.image"
							:src="asset(wordPack.image)"
							alt=""
							class="object-cover w-48 h-48 rounded-md" />
						<p
							class="max-w-48 my-auto text-sm text-center text-gray-900 break-words">
							{{ wordPack.description }}
						</p>
					</div>
				</div>

				<div class="flex items-center justify-center w-full gap-2">
					<button @click="previousPage" :disabled="page <= 1 || loading">
						<i
							class="bx bxs-chevron-left bx-md text-gray-100"
							:class="{
								'opacity-50': page <= 1,
							}">
						</i>
					</button>

					<span class="mb-1 text-xl font-bold text-gray-100">
						{{ page }}
					</span>

					<button @click="nextPage" :disabled="page >= maxPage || loading">
						<i
							class="bx bxs-chevron-right bx-md text-gray-100"
							:class="{
								'opacity-50': page >= maxPage,
							}">
						</i>
					</button>
				</div>
			</div>
		</div>
	</section>

	<WordPackModal ref="wordPackModal"></WordPackModal>
</template>
<script setup>
import WordPackModal from "@/components/word-packs/WordPackModal.vue";
import { asset } from "@/utils/asset";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { computed, onMounted, ref, watch } from "vue";

// Lifecycle
onMounted(async () => {
	loadWordPacks();
});

// Variables
const wordPacks = ref([]);

const wordPackModal = ref(null);

const page = ref(1);
const maxPage = ref(1);
const loading = ref(false);

const search = ref("");
const searchInput = ref(null);

// Functions
async function loadWordPacks() {
	loading.value = true;

	let requestUrl = "/api/word-packs?visibility=public";
	requestUrl += "&page=" + page.value;
	if (search.value) {
		requestUrl += "&search=" + search.value;
	}

	await handleRequest({
		request: () => axios.get(requestUrl),
		successCallback: async (response) => {
			page.value = response.data.current_page;
			maxPage.value = response.data.last_page;

			// response.data is Laravel pagination object, inside it is data field with the data
			wordPacks.value = response.data.data;
		},
		failCallback: async (response) => {
			console.error("Could not load word packs from the database.", response);
		},
	});

	loading.value = false;
}

async function previousPage() {
	if (page.value > 1) {
		page.value -= 1;

		await loadWordPacks();
	}
}

async function nextPage() {
	if (page.value != maxPage) {
		page.value += 1;

		await loadWordPacks();
	}
}

// Watcher
watch(
	() => search.value,
	(newSearch, oldSearch) => {
		page.value = 1;

		loadWordPacks();
	}
);
</script>
