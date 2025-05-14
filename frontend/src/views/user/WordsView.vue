<template>
	<section class="flex flex-col items-stretch justify-center w-full gap-8">
		<h2 class="text-4xl font-bold text-center text-gray-900">My words</h2>
		<!-- Words -->
		<form @submit.prevent="search = searchInput.value">
			<input
				ref="searchInput"
				type="search"
				name="search"
				placeholder="Search"
				class="input bg-secondary-300 placeholder:text-secondary-content-300 focus:placeholder:text-opacity-0 sm:block text-secondary-content-300 hidden border-0" />
		</form>

		<template v-if="words.length > 0">
			<table class="w-full">
				<thead class="border-primary-300 p-2 border">
					<tr>
						<th class="border-primary-300 p-1 text-center border">Word</th>
						<th class="border-primary-300 p-1 text-center border">
							Word translation
						</th>
						<th
							class="md:table-cell border-primary-300 hidden p-1 text-center border">
							Image
						</th>
						<th class="border-primary-300 p-1 text-center border">Actions</th>
					</tr>
				</thead>
				<tbody class="border-primary-300 p-2 border">
					<tr v-for="userWord in words" class="border-primary-300 border">
						<td class="border-primary-300 px-2 py-1 border">
							{{ userWord.word.word }}
						</td>
						<td class="border-primary-300 px-2 py-1 border">
							{{ userWord.word.word_translation }}
						</td>
						<td
							class="md:table-cell border-primary-300 hidden px-2 py-1 text-center border">
							<img
								v-if="userWord.word.image"
								:src="asset(userWord.word.image)"
								alt=""
								class="w-20 h-20 mx-auto" />
							<p v-else>No image</p>
						</td>
						<td class="border-primary-300 px-2 py-1 text-center border">
							<button
								@click="handleDelete(userWord.id, userWord.word.word)"
								class="text-red-500">
								<i class="bx bxs-trash bx-sm"></i>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="flex items-center justify-center w-full gap-2">
				<button @click="previousPage" :disabled="page <= 1 || loading">
					<i
						class="bx bxs-chevron-left bx-md text-gray-900"
						:class="{
							'opacity-50': page <= 1,
						}">
					</i>
				</button>

				<span class="mb-1 text-xl font-bold text-gray-900">
					{{ page }}
				</span>

				<button @click="nextPage" :disabled="page >= maxPage || loading">
					<i
						class="bx bxs-chevron-right bx-md text-gray-900"
						:class="{
							'opacity-50': page >= maxPage,
						}">
					</i>
				</button>
			</div>
		</template>
		<p
			v-else-if="!hasWords && !search"
			class="pb-2 text-xl font-bold text-center text-gray-700">
			You don't have any words added!
		</p>
		<p v-else class="pb-2 text-xl font-bold text-center text-gray-700">
			No words were found.
		</p>
	</section>
</template>
<script setup>
import router from "@/router";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref, watch, computed } from "vue";
import { asset } from "@/utils/asset";
import { useRoute } from "vue-router";

// Composables
const route = useRoute();

// Lifecycle hooks
onMounted(async () => {
	await loadWords();
});

// Variables
const words = ref({});
const page = ref(1);
const maxPage = ref(1);
const loading = ref(false);
const deleting = ref(false);

const search = ref("");
const searchInput = ref(null);

// Computed
const hasWords = computed(
	() => words.value && Object.keys(words.value).length > 0
);

// Functions
async function loadWords() {
	if (loading.value) {
		return;
	}

	loading.value = true;

	let requestUrl = "/api/user/words";
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
			words.value = response.data.data;
		},
		failCallback: async (response) => {
			console.error("Could not load user words from the database.", response);
		},
	});

	loading.value = false;
}

async function handleDelete(id, word) {
	if (deleting.value) {
		return;
	}

	confirm("Are you sure you want to delete the word " + word + "?");

	deleting.value = true;

	// TODO: delete request
	await handleRequest({
		request: () => axios.delete("/api/user/words/" + id),
		successCallback: async (response) => {
			await loadWords();
		},
	});

	deleting.value = false;
}

async function previousPage() {
	if (page.value > 1) {
		page.value -= 1;

		await loadWords();
	}
}

async function nextPage() {
	if (page.value != maxPage) {
		page.value += 1;

		await loadWords();
	}
}

// Watcher
watch(
	() => search.value,
	(newSearch, oldSearch) => {
		page.value = 1;

		loadWords();
	}
);
</script>
