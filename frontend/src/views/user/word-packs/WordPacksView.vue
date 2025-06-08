<template>
	<section class="flex flex-col items-stretch justify-center w-full gap-8">
		<h2 class="text-4xl font-bold text-center text-gray-900">My word packs</h2>

		<div class="sm:justify-between flex items-center justify-start">
			<form @submit.prevent="search = searchInput.value">
				<input
					ref="searchInput"
					type="search"
					name="search"
					placeholder="Search"
					class="input bg-secondary-300 placeholder:text-secondary-content-300 focus:placeholder:text-opacity-0 sm:block text-secondary-content-300 hidden border-0" />
			</form>

			<RouterLink
				:to="{ name: 'user-word-packs-create' }"
				class="btn-secondary">
				Create word pack
			</RouterLink>
		</div>

		<template v-if="hasWordPacks">
			<!-- Word packs -->
			<div
				class="md:flex-row bg-secondary-300 flex flex-col gap-4 p-4 rounded-md">
				<div
					v-for="wordPack in possibleWordPacks"
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
			v-else-if="!hasWordPacks && !search"
			class="pb-2 text-xl font-bold text-center text-gray-700">
			You don't have any word packs added!
		</p>
		<p v-else class="pb-2 text-xl font-bold text-center text-gray-700">
			No word packs were found.
		</p>
	</section>

	<WordPackModal ref="wordPackModal"></WordPackModal>
</template>
<script setup>
import WordPackModal from "@/components/word-packs/WordPackModal.vue";
import router from "@/router";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref, watch, computed } from "vue";
import { asset } from "@/utils/asset";
import { useRoute } from "vue-router";
import { useUserStore } from "@/stores/user";
import { storeToRefs } from "pinia";

// Stores
const userStore = useUserStore();
const { userWordPacks } = storeToRefs(userStore);

// Composables
const route = useRoute();

// Lifecycle hooks
onMounted(async () => {
	await loadWordPacks();
});

// Variables
const wordPacks = ref([]);
const page = ref(1);
const maxPage = ref(1);
const loading = ref(false);

const search = ref("");
const searchInput = ref(null);

const wordPackModal = ref(null);

// Computed
const hasWordPacks = computed(
	() => possibleWordPacks.value && possibleWordPacks.value.length > 0
);
const possibleWordPacks = computed(() => {
	const ids = userWordPacks.value.map((u) => u.word_pack_id);

	return wordPacks.value.filter((wp) => ids.includes(wp.id));
});

// Functions
async function loadWordPacks() {
	if (loading.value) {
		return;
	}

	loading.value = true;

	let requestUrl = "/api/user/word-packs";
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
			console.error(
				"Could not load user word packs from the database.",
				response
			);
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
