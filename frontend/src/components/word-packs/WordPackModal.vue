<template>
	<!-- Word pack modal (1) -->
	<div
		id="word-pack-modal"
		class="aria-hidden:hidden fixed top-0 left-0 z-50 w-screen h-screen overflow-scroll"
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
					v-if="modalWordPackExists"
					class="border-primary-100 w-full py-1 border-b">
					<h2
						id="word-pack-modal-title"
						class="mx-5 text-2xl font-bold text-center">
						{{ modalWordPack.name }}
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
					<template v-if="modalWordPackExists">
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
											class="accent-white add-word-input w-6 h-6" />
									</td>
								</tr>
							</tbody>
						</table>
						<p
							v-else-if="!modalWordPackHasWords"
							class="pb-2 text-xl font-bold text-center text-gray-700">
							There are no words in this word pack!
						</p>
					</template>
					<p v-else class="pb-2 text-xl text-center">Loading...</p>
				</main>

				<footer
					class="border-primary-100 flex flex-wrap justify-center w-full gap-4 p-2 border-t">
					<p v-if="modalError" class="text-lg font-bold text-red-400">
						{{ modalError }}
					</p>
					<template v-if="modalAction == 'add' && modalWordPackHasWords">
						<button
							@click="addWordPack"
							class="bg-primary-100 text-primary-content-100 flex items-center justify-center gap-1 text-lg px-1 py-0.5 rounded-md">
							<i v-if="modalActionLoading != 'add'" class="bx bxs-download"></i>
							<i v-else class="bx bx-loader-alt animate-spin"></i>
							Add to your vocab.
						</button>
					</template>
					<template v-else-if="modalAction == 'update'">
						<button
							@click="updateWordPack"
							class="bg-primary-100 text-primary-content-100 flex items-center justify-center gap-1 text-lg px-1 py-0.5 rounded-md">
							<i v-if="modalActionLoading != 'update'" class="bx bxs-edit"></i>
							<i v-else class="bx bx-loader-alt animate-spin"></i>
							Update your vocab.
						</button>
						<button
							@click="removeWordPack"
							class="bg-primary-100 text-primary-content-100 flex items-center justify-center gap-1 text-lg px-1 py-0.5 rounded-md">
							<i v-if="modalActionLoading != 'remove'" class="bx bxs-trash"></i>
							<i v-else class="bx bx-loader-alt animate-spin"></i>
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
import { computed, onMounted, ref, watch } from "vue";
import MicroModal from "micromodal";
import { useUserStore } from "@/stores/user";
import { storeToRefs } from "pinia";

// Define
defineExpose({
	openWordPackModal,
});

// Stores
const userStore = useUserStore();
const { userWordPacks } = storeToRefs(userStore);

// Variables
const modalWordPack = ref({});
const modalAction = ref("add");
const modalActionLoading = ref(false);
const modalError = ref("");

// Computed
const modalWordPackExists = computed(
	() => Object.keys(modalWordPack.value).length > 0
);
const modalWordPackHasWords = computed(
	() =>
		modalWordPack.value &&
		modalWordPack.value.words &&
		modalWordPack.value.words.length > 0
);

// Functions
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

async function addWordPack() {
	// Get words that the user doesnt want to add
	const except = getModalExceptWords();

	modalActionLoading.value = "add";

	await handleRequest({
		request: (data) =>
			axios.post(
				"/api/user/word-packs/" + modalWordPack.value.id + "/add",
				data
			),
		requestData: {
			except_words: except,
		},
		successCallback: async (response) => {
			userWordPacks.value = response.data.user_word_packs;

			modalAction.value = "update";

			modalActionLoading.value = "";
		},
	});
}

async function updateWordPack() {
	// Get words that the user doesnt want to add
	const except = getModalExceptWords();

	modalActionLoading.value = "update";

	await handleRequest({
		request: (data) =>
			axios.post(
				"/api/user/word-packs/" + modalWordPack.value.id + "/update",
				data
			),
		requestData: {
			except_words: except,
		},
		successCallback: async (response) => {
			userWordPacks.value = response.data.user_word_packs;

			modalAction.value = "update";

			modalActionLoading.value = "";
		},
	});
}

async function removeWordPack() {
	modalActionLoading.value = "remove";

	await handleRequest({
		request: () =>
			axios.post("/api/user/word-packs/" + modalWordPack.value.id + "/remove"),
		successCallback: async (response) => {
			userWordPacks.value = response.data.user_word_packs;

			modalAction.value = "add";

			modalActionLoading.value = "";
		},
	});
}

function getModalExceptWords() {
	const inputs = document.getElementsByClassName("add-word-input");
	const except = [];
	for (let i = 0; i < inputs.length; i++) {
		if (!inputs[i].checked) {
			except.push(modalWordPack.value.words[i].id);
		}
	}

	// The user didnt add any word, why?
	if (except.length == inputs.length) {
		modalError.value = "You need to add at least one word!";
		return;
	}

	return except;
}
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
