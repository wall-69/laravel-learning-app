<template>
	<div class="grow flex flex-col items-center justify-center gap-2 bg-white">
		<template v-if="!finished">
			<!-- Stats -->
			<div
				v-if="currentWord && words.length > 0"
				class="flex items-center justify-center gap-8">
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
			<div v-if="currentWord && words.length > 0" class="flex gap-8">
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
				class="bg-secondary-200 text-secondary-content-200 flex flex-col justify-between items-center gap-4 px-8 h-96 sm:h-[30rem] sm:w-96 w-80 py-4 text-center rounded-lg shadow-md">
				<div class="flex flex-col items-center gap-2">
					<h2 class="flex items-center gap-1 text-2xl font-bold">
						<i class="bx bxs-party"></i> Congratulations!
						<i class="bx bxs-party"></i>
					</h2>
					<p v-if="!hitDailyLimit">
						You finished reviewing your daily words. Good job!
					</p>
					<p v-else>
						You hit your daily review limit. Good job! <br />
						You can change it in
						<RouterLink :to="{ name: 'profile' }" class="font-bold underline">
							your settings </RouterLink
						>.
					</p>
				</div>

				<div class="flex flex-col items-center gap-3">
					<h3 class="text-xl font-bold">Did you know?</h3>
					<p>
						{{ getRandomFunFact }}
					</p>
				</div>

				<RouterLink
					@click="addTodayToReviewed()"
					:to="{ name: 'learning' }"
					class="btn-primary">
					Dashboard
				</RouterLink>
			</div>
		</template>
	</div>
</template>
<script setup>
import axios from "axios";
import { nextTick, onMounted, ref, computed } from "vue";
import { handleRequest } from "@/utils/requestWrapper";
import { asset } from "@/utils/asset";
import { RouterLink } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";
import { useRoute } from "vue-router";

// Stores
const { user } = storeToRefs(useAuthStore());

// Composables
const route = useRoute();

// Lifecycle
onMounted(async () => {
	if (user.value.todayReviews >= dailyLimit.value) {
		hitDailyLimit.value = true;
		finished.value = true;
		return;
	}

	if (route.query.wordPack) {
		mode.value = "revisit";
		await loadWordPack(route.query.wordPack);
	} else {
		await loadDueWords();
	}
});

// Variables
const mode = ref("due");
const card = ref(null);
const revealed = ref(false);
const scrollable = ref(null);
const finished = ref(false);
const hitDailyLimit = ref(false);

const words = ref([]);
const currentWord = ref({});

const funFacts = [
	"Spaced repetition strengthens memory more than cramming.",
	"Reviewing just before forgetting helps lock in knowledge.",
	"Retrieving a memory makes it stronger, it's called the testing effect.",
	"Active recall beats passive review every time.",
	"Teaching what you know reinforces your own understanding.",
	"Consistent daily review beats long study sessions.",
	"Challenging learning sticks better, it's called desirable difficulty.",
	"Believing you can improve memory actually helps you do it.",
	"Memory is stored in patterns and connections, not single spots.",
	"Sleep helps your brain organize and store what you've learned.",
	"Writing by hand activates more areas of the brain than typing.",
	"Regular review signals your brain that info is important.",
	"Mistakes plus feedback help build stronger memories.",
	"Switching between related topics while studying improves flexible thinking and long-term retention.",
	"Using multiple senses strengthens memory retention.",
	"Struggling to remember helps reinforce the memory.",
	"New information sticks better when connected to what you already know.",
	"Your brain builds mental maps to organize knowledge.",
	"Learning new vocabulary exercises and grows your brain.",
	"Your brain rewires itself every time you learn something new, it's called neuroplasticity.",
	"Even brief mental breaks improve focus and memory consolidation.",
	"Explaining concepts to yourself out loud sharpens understanding and recall.",
	"Changing your study environment can enhance memory by adding contextual cues.",
	"The more meaningful or emotional the material, the more likely your brain is to store it.",
];

// Computed
const getRandomFunFact = computed(
	() => funFacts[Math.floor(Math.random() * funFacts.length)]
);
const dailyLimit = computed(
	() => user.value.user_settings?.settings?.daily_reviews ?? 25
);

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

		if (mode.value == "due") {
			// Make request to mark the word as correctly answered
			handleRequest({
				request: () =>
					axios.post("/api/user/words/" + correctWord.id + "/correct"),
			});

			// Increment today reviews in client
			user.value.todayReviews++;

			// Max daily reviews
			if (user.value.todayReviews >= dailyLimit.value) {
				hitDailyLimit.value = true;
			}
		}
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

	// If the user hasnt hit their daily review limit and there are remaining words we set the first one in the list as the current one
	if (!hitDailyLimit.value && words.value.length > 0) {
		currentWord.value = words.value[0];
	} else {
		// If there are no more words mark as finished
		finished.value = true;

		if (mode.value == "due") {
			// Mark today as reviewed, yay
			await handleRequest({
				request: () => axios.post("/api/user/review/today"),
				successCallback: async (response) => {
					addTodayToReviewed();
				},
				failCallback: async (response) => {
					console.error("Could not mark today as reviewed.");
				},
			});
		}
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

async function loadWordPack(id) {
	await handleRequest({
		request: () => axios.get("/api/user/words/revisit/" + id),
		successCallback: async (response) => {
			words.value = response.data.revisit_words;
			currentWord.value = words.value[0];

			if (words.value.length == 0) {
				finished.value = true;
			}
		},
		failCallback: async (response) => {
			console.error("Could not load revisit words.");
		},
	});
}

function addTodayToReviewed() {
	if (user.value.hasWords) {
		return;
	}

	const now = new Date();
	const yyyy = now.getUTCFullYear();
	const mm = String(now.getUTCMonth() + 1).padStart(2, "0");
	const dd = String(now.getUTCDate()).padStart(2, "0");
	const formatted = yyyy + "-" + mm + "-" + dd + "T00:00:00.000000Z";

	const reviews = user.value.user_reviews;
	const reviewKeys = Object.keys(reviews);
	if (reviewKeys.length > 0) {
		const lastReview = reviews[reviewKeys[reviewKeys.length - 1]];
		if (lastReview.date === formatted) {
			return;
		}
	}

	user.value.user_reviews.push({
		created_at: formatted,
		updated_at: formatted,
		date: formatted,
		user_id: user.value.id,
	});

	user.value.hasDueWords = false;
}
</script>

<!-- 
	Inspiration: https://dribbble.com/shots/10827971-Vocabulary-App
-->
