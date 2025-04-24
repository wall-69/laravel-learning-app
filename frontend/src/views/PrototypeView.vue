<template>
	<div
		class="grow flex flex-col items-center justify-center gap-8 px-8 py-6 bg-white">
		<!-- Stats -->
		<div class="flex items-center justify-center gap-8">
			<span class="text-4xl font-bold">{{ remainingWords }}</span>
		</div>

		<!-- Card -->
		<div
			ref="card"
			class="bg-secondary-200 text-secondary-content-200 h-96 sm:h-[30rem] sm:w-96 relative flex flex-col w-80 text-center rounded-lg shadow-md">
			<!-- Scrollable child -->
			<div
				ref="scrollable"
				v-if="word && words.length > 0"
				class="overflow-wrap-anywhere flex flex-col items-center justify-center h-full gap-5 px-8 py-4 overflow-y-scroll break-words">
				<!-- Front -->
				<template v-if="!revealed">
					<!-- Word -->
					<span class="mt-auto text-3xl font-bold">{{ word.word }}</span>

					<!-- Image -->
					<!-- <img
						v-if="word.image"
						:src="word.image"
						alt=""
						class="sm:h-24 sm:w-24 object-fill w-20 h-20 rounded-sm shadow-lg" /> -->

					<!-- Example -->
					<div class="flex flex-col self-start gap-1 mt-auto">
						<span
							class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
							EXAMPLE
						</span>

						<p class="text-left">{{ word.example }}</p>
					</div>
				</template>

				<!-- Back -->
				<template v-else>
					<!-- Word - translated -->
					<span class="mt-auto text-3xl font-bold">
						{{ word.word_translation }}
					</span>

					<!-- Image -->
					<img
						v-if="word.image"
						:src="asset(word.image)"
						alt=""
						class="sm:h-24 sm:w-24 object-fill w-20 h-20 rounded-sm shadow-lg" />

					<!-- Example - translated -->
					<div class="flex flex-col self-start gap-1 mt-auto">
						<span
							class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
							EXAMPLE
						</span>
						<p class="text-left">{{ word.example_translation }}</p>
					</div>

					<!-- Explanation -->
					<div class="flex flex-col self-start gap-1">
						<span
							class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
							EXPLANATION
						</span>
						<p class="text-left">
							{{ word.explanation }}
						</p>
					</div>
				</template>
			</div>
			<div v-else class="my-auto">
				<p class="text-xl">Loading...</p>
			</div>
		</div>

		<!-- Controls -->
		<div class="flex gap-8">
			<!-- Show card -->
			<template v-if="!revealed">
				<button
					v-if="!revealed"
					@click="handleReveal"
					class="p-2 rounded-xl transition-all hover:-translate-y-1 shadow-[0px_0px_5px_3px_rgba(0,0,0,0.2)]">
					<i class="bx bxs-show bx-lg text-primary-500 flex"></i>
				</button>
			</template>

			<!-- Correct/incorrect -->
			<template v-else>
				<button
					@click="handleAnswer(false)"
					class="p-2 rounded-xl transition-all hover:-translate-y-1 shadow-[0px_0px_5px_3px_rgba(0,0,0,0.2)]">
					<i class="bx bx-dislike bx-lg flex text-red-300"></i>
				</button>
				<button
					@click="handleAnswer(true)"
					class="p-2 rounded-xl transition-all hover:-translate-y-1 shadow-[0px_0px_5px_3px_rgba(0,0,0,0.2)]">
					<i class="bx bxs-like bx-lg flex text-green-300"></i>
				</button>
			</template>
		</div>
	</div>
</template>
<script setup>
import axios from "axios";
import { nextTick, onMounted, ref, computed } from "vue";
import { handleRequest } from "@/utils/requestWrapper";
import { asset } from "@/utils/asset";

// Lifecycle
onMounted(async () => {
	await loadDueWords();
});

// Variables
const card = ref(null);
const word = ref({});
const revealed = ref(false);
const answered = ref(false);
const scrollable = ref(null);

const words = ref([]);

// Computed
const remainingWords = computed(() => {
	if (words.value.length == 0) {
		return 0;
	}

	return words.value.length - words.value.indexOf(word.value);
});

// Functions
function handleReveal() {
	revealed.value = true;

	// Scroll to top of the card
	nextTick(() => {
		scrollable.value.scrollTop = 0;
	});
}

function handleAnswer(correct) {
	answered.value = true;

	// Show next card

	const currentWordIdx = words.value.indexOf(word.value);
	if (currentWordIdx == -1) {
		// TODO: idfk
		return;
	}

	if (remainingWords.value == 1) {
		// TODO: end
		return;
	}

	word.value = words.value[currentWordIdx + 1];

	revealed.value = false;
	answered.value = false;
}

async function loadDueWords() {
	await handleRequest({
		request: () => axios.get("/api/user/words/due"),
		successCallback: async (response) => {
			words.value = response.data.due_words;
			word.value = words.value[0];
		},
		failCallback: async (response) => {
			console.error("Could not load due words.");
		},
	});
}
</script>

<!-- 
insp: https://dribbble.com/shots/10827971-Vocabulary-App
-->
