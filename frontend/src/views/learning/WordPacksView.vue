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
						@click="openWordPackModal(wordPack.id)"
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

	<!-- Word pack modal (1) -->
	<div
		id="word-pack-modal"
		class="aria-hidden:hidden absolute top-0 left-0 z-50 w-screen h-screen overflow-scroll"
		aria-hidden="true">
		<!-- Word pack modal overlay (2) -->
		<div
			class="text-gray-50 flex items-center justify-center w-full h-full bg-gray-900 bg-opacity-50"
			tabindex="-1">
			<!-- Word pack modal content (3) -->
			<div
				class="bg-secondary-100 min-h-max relative flex flex-col items-center justify-center w-full max-w-lg max-h-full px-4 py-2 m-4 rounded-md"
				role="dialog"
				aria-modal="true"
				aria-labelledby="word-pack-modal-title">
				<header
					v-if="Object.keys(modalWordPack).length > 0"
					class="border-primary-100 w-full py-1 border-b">
					<h2
						id="word-pack-modal-title"
						class="mx-5 text-2xl font-bold text-center">
						{{ modalWordPack ? modalWordPack.name : "Loading..." }}
					</h2>

					<!-- Word pack modal close (4) -->
					<button
						class="hover:bg-gray-300 rounded-tr-md rounded-bl-md absolute top-0 right-0 flex items-center text-xl text-gray-900 transition-colors bg-gray-100"
						aria-label="Close modal"
						data-micromodal-close>
						<i class="bx bx-x bx-md"></i>
					</button>
				</header>

				<main
					id="word-pack-modal-content"
					class="flex flex-col gap-4 pt-2 overflow-y-scroll">
					<template v-if="Object.keys(modalWordPack).length > 0">
						<!-- Image -->
						<img
							v-if="modalWordPack.image"
							:src="asset(modalWordPack.image)"
							alt=""
							class="self-center w-48 h-48 rounded-md" />

						<!-- Description -->
						<p class="text-center">
							{{ modalWordPack.description }}
						</p>

						<!-- Words -->
						<table v-if="modalWordPack.words.length > 0">
							<thead class="border-primary-300 p-2 border">
								<tr>
									<th class="border-primary-300 p-1 text-center border">
										Word
									</th>
									<th class="border-primary-300 p-1 text-center border">
										Word translation
									</th>
									<th
										class="md:table-cell border-primary-300 hidden p-1 text-center border">
										Image
									</th>
									<th class="border-primary-300 p-1 text-center border">Add</th>
								</tr>
							</thead>
							<tbody class="border-primary-300 p-2 border">
								<tr
									v-for="word in modalWordPack.words"
									class="border-primary-300 border">
									<td class="border-primary-300 px-2 py-1 border">
										{{ word.word }}
									</td>
									<td class="border-primary-300 px-2 py-1 border">
										{{ word.word_translation }}
									</td>
									<td
										class="md:table-cell border-primary-300 hidden px-2 py-1 text-center border">
										<img
											v-if="word.image"
											:src="asset(word.image)"
											alt=""
											class="w-20 h-20" />
										<p v-else>No image</p>
									</td>
									<td class="border-primary-300 px-2 py-1 text-center border">
										<input
											type="checkbox"
											checked="true"
											class="accent-white w-6 h-6" />
									</td>
								</tr>
							</tbody>
						</table>
						<p
							v-else-if="
								modalWordPack &&
								modalWordPack.words &&
								modalWordPack.words.length == 0
							"
							class="pb-2 text-xl font-bold text-center text-gray-700">
							There are no words in this word pack!
						</p>
					</template>
					<p v-else class="pb-2 text-xl text-center">Loading...</p>
				</main>

				<footer
					class="border-primary-100 flex flex-wrap justify-center w-full gap-4 p-2 border-t">
					<template
						v-if="
							modalAction == 'add' &&
							modalWordPack &&
							modalWordPack.words &&
							modalWordPack.words.length > 0
						">
						<button
							class="bg-primary-100 text-primary-content-100 flex items-center justify-center gap-1 text-lg px-1 py-0.5 rounded-md">
							<i class="bx bxs-download"></i>
							Add to your vocab.
						</button>
					</template>
					<template v-else-if="modalAction == 'update'">
						<button
							class="bg-primary-100 text-primary-content-100 flex items-center justify-center gap-1 text-lg px-1 py-0.5 rounded-md">
							<i class="bx bxs-edit"></i>
							Update your vocab.
						</button>
						<button
							class="bg-primary-100 text-primary-content-100 flex items-center justify-center gap-1 text-lg px-1 py-0.5 rounded-md">
							<i class="bx bxs-trash"></i>
							Delete from your vocab.
						</button>
					</template>
				</footer>
			</div>
		</div>
	</div>
</template>
<script setup>
import { asset } from "@/utils/asset";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import MicroModal from "micromodal";
import useUserData from "@/composables/useUserData";

// Composables
const { wordPacks: userWordPacks } = useUserData();

// Lifecycle
onMounted(async () => {
	loadWordPacks();
});

// Variables
const wordPacks = ref([]);

const modalAction = ref("add");
const modalWordPack = ref({});

const page = ref(1);
const maxPage = ref(1);
const loading = ref(false);

const search = ref("");
const searchInput = ref(null);

// Functions
async function loadWordPacks() {
	loading.value = true;

	let requestUrl = "/api/word-packs";
	requestUrl += "?page=" + page.value;
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

async function openWordPackModal(wordPackId) {
	const alreadyHas = userWordPacks.value.find(
		(userWordPack) => userWordPack.word_pack_id == wordPackId
	);

	if (!alreadyHas) {
		modalAction.value = "add";
	} else {
		modalAction.value = "update";
	}

	// Show modal
	MicroModal.show("word-pack-modal", {
		disableScroll: true,
		onClose: (modal) => {
			modalWordPack.value = {};
		},
	});

	// Get word pack by ID
	await handleRequest({
		request: () => axios.get("/api/word-packs/" + wordPackId + "/words"),
		successCallback: async (response) => {
			modalWordPack.value = response.data;
		},
	});
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
<style>
#word-pack-modal {
	animation: openModal 0.5s ease;
}

@keyframes openModal {
	0% {
		opacity: 0;
	}

	100% {
		opacity: 1;
	}
}
</style>
