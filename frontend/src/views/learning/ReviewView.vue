<template>
	<div class="grow flex flex-col items-center justify-center gap-2 bg-white">
		<template v-if="!finished">
			<!-- Stats -->
			<div class="flex items-center justify-center gap-8">
				<span class="text-4xl font-bold">{{ words.length }}</span>
			</div>

			<!-- Card -->
			<div
				ref="card"
				class="bg-secondary-200 text-secondary-content-200 h-96 sm:h-[30rem] sm:w-96 relative flex flex-col w-80 text-center rounded-lg shadow-md">
				<!-- Scrollable child -->
				<div
					ref="scrollable"
					v-if="currentWord && words.length > 0"
					class="overflow-wrap-anywhere flex flex-col items-center justify-center h-full gap-5 px-8 py-4 overflow-y-scroll break-words">
					<!-- Front -->
					<template v-if="!revealed">
						<!-- Word -->
						<span class="mt-auto text-3xl font-bold">{{
							currentWord.word.word
						}}</span>

						<!-- Image -->
						<img
							v-if="currentWord.word.image"
							:src="asset(currentWord.word.image)"
							alt=""
							class="sm:h-24 sm:w-24 object-fill w-20 h-20 rounded-sm shadow-lg" />

						<!-- Example -->
						<div class="flex flex-col self-start gap-1 mt-auto">
							<span
								class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
								EXAMPLE
							</span>

							<p class="text-left">{{ currentWord.word.example }}</p>
						</div>
					</template>

					<!-- Back -->
					<template v-else>
						<!-- Word - translated -->
						<span class="mt-auto text-3xl font-bold">
							{{ currentWord.word.word_translation }}
						</span>

						<!-- Image -->
						<img
							v-if="currentWord.word.image"
							:src="asset(currentWord.word.image)"
							alt=""
							class="sm:h-24 sm:w-24 object-fill w-20 h-20 rounded-sm shadow-lg" />

						<!-- Example - translated -->
						<div class="flex flex-col self-start gap-1 mt-auto">
							<span
								class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
								EXAMPLE
							</span>
							<p class="text-left">
								{{ currentWord.word.example_translation }}
							</p>
						</div>

						<!-- Explanation -->
						<div class="flex flex-col self-start gap-1">
							<span
								class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
								EXPLANATION
							</span>
							<p class="text-left">
								{{ currentWord.word.explanation }}
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
		</template>
		<template v-else>
			<div
				class="bg-secondary-200 text-secondary-content-200 flex flex-col items-center px-8 py-4 text-center rounded-lg shadow-md">
				<h2 class="text-2xl font-bold">Congratulations!</h2>
				<p>You finished your daily words. Good job!</p>

				<RouterLink
					@click="addTodayToReviewed"
					:to="{ name: 'learning' }"
					class="bg-primary-200 text-primary-content-200 px-2 py-1 mt-4 text-lg rounded-md shadow-md">
					Dashboard
				</RouterLink>
			</div>
		</template>
	</div>
</template>
<script setup>
import axios from "axios";
import { nextTick, onMounted, ref } from "vue";
import { handleRequest } from "@/utils/requestWrapper";
import { asset } from "@/utils/asset";
import { RouterLink } from "vue-router";
import useAuth from "@/composables/useAuth";

// Composables
const { user, setUser } = useAuth();

// Lifecycle
onMounted(async () => {
	await loadDueWords();
});

// Variables
const card = ref(null);
const revealed = ref(false);
const scrollable = ref(null);
const finished = ref(false);

const words = ref([]);
const currentWord = ref({});

// Functions
function handleReveal() {
	revealed.value = true;

	// Scroll to top of the card
	nextTick(() => {
		scrollable.value.scrollTop = 0;
	});
}

async function handleAnswer(correct) {
	// Current word index in words list
	const currentWordIdx = words.value.indexOf(currentWord.value);
	if (currentWordIdx == -1) {
		// todo: idk
		return;
	}

	if (correct) {
		// Remove current word from the pack, if answered correctly
		const correctWord = words.value.shift();

		// Make request to mark the word as correctly answered
		handleRequest({
			request: () =>
				axios.post("/api/user/words/" + correctWord.id + "/correct"),
		});
	} else {
		// Remove the failed word from the words list, but keep it
		const failedWord = words.value.shift();
		// Set the failed word's group as 0 (so it will then be set to 1)
		failedWord.group = 0;

		// If there are no more words remaining, we need to put the word to index 0
		let randomIdx = 0;

		// If there are other words remaining, we can generate random index
		if (words.value.length != 0) {
			// Generate random index from 1 to the number of remaining words
			randomIdx = Math.floor(Math.random() * words.value.length + 1);
		}

		// Add the word back into
		words.value.splice(randomIdx, 0, failedWord);
	}

	// If there are remaining words we set the first one in the list as the current one
	if (words.value.length > 0) {
		currentWord.value = words.value[0];
	} else {
		// If there are no more words mark as finished
		finished.value = true;

		// Mark today as reviewed, yay
		await handleRequest({
			request: () => axios.post("/api/user/review/today"),
			successCallback: async (response) => {
				// TODO: probably nothing
				console.log("yipee");
			},
			failCallback: async (response) => {
				console.error("Could not mark today as reviewed.");
			},
		});
	}

	// Make the card not revealed
	revealed.value = false;
}

async function loadDueWords() {
	await handleRequest({
		request: () => axios.get("/api/user/words/due"),
		successCallback: async (response) => {
			words.value = response.data.due_words;
			currentWord.value = words.value[0];

			if (words.value.length == 0) {
				finished.value = true;
			}
		},
		failCallback: async (response) => {
			console.error("Could not load due words.");
		},
	});
}

function addTodayToReviewed() {
	const now = new Date();
	const yyyy = now.getUTCFullYear();
	const mm = String(now.getUTCMonth() + 1).padStart(2, "0");
	const dd = String(now.getUTCDate()).padStart(2, "0");
	const formatted = yyyy + "-" + mm + "-" + dd + "T00:00:00.000000Z";

	const lastReview =
		user.value.user_reviews[Object.keys(user.value.user_reviews).length - 1];
	if (lastReview.date == formatted) {
		return;
	}

	user.value.user_reviews.push({
		created_at: formatted,
		updated_at: formatted,
		date: formatted,
		user_id: user.value.id,
	});

	setUser(user);
}
</script>

<!-- 
insp: https://dribbble.com/shots/10827971-Vocabulary-App
-->
