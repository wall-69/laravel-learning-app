W
<template>
	<div
		class="grow flex flex-col items-center justify-center gap-8 px-8 py-6 bg-white">
		<!-- Stats -->
		<div class="flex items-center justify-center gap-8">
			<span class="text-4xl font-bold">15</span>
		</div>

		<!-- Card -->
		<div
			ref="card"
			class="bg-secondary-200 text-secondary-content-200 h-96 sm:h-[30rem] sm:w-96 relative flex flex-col w-80 text-center rounded-lg shadow-md">
			<!-- Scrollable child -->
			<div
				ref="scrollable"
				class="overflow-wrap-anywhere flex flex-col items-center justify-center h-full gap-5 px-8 py-4 overflow-y-scroll break-words">
				<!-- Front -->
				<template v-if="!revealed">
					<!-- Word -->
					<span class="text-3xl font-bold">{{ word.word }}</span>

					<!-- Image -->
					<!-- <img
						v-if="word.image"
						:src="word.image"
						alt=""
						class="sm:h-24 sm:w-24 object-fill w-20 h-20 rounded-sm shadow-lg" /> -->

					<!-- Example -->
					<div class="flex flex-col gap-1">
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
					<span class="text-3xl font-bold">
						{{ word.wordTranslation }}
					</span>

					<!-- Image -->
					<img
						v-if="word.image"
						:src="word.image"
						alt=""
						class="sm:h-24 sm:w-24 object-fill w-20 h-20 rounded-sm shadow-lg" />

					<!-- Example - translated -->
					<div class="flex flex-col gap-1">
						<span
							class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
							EXAMPLE
						</span>
						<p class="text-left">{{ word.exampleTranslation }}</p>
					</div>

					<!-- Explanation -->
					<div class="flex flex-col gap-1">
						<span
							class="text-xs font-bold bg-primary-200 px-1.5 py-0.5 rounded-lg text-primary-content-200 self-start">
							EXPLANATION
						</span>
						<p class="text-sm text-left">
							{{ word.explanation }}
						</p>
					</div>
				</template>
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
import { nextTick, onMounted, ref } from "vue";

// Variables
const card = ref(null);
const word = ref({
	word: "to contribute",
	wordTranslation: "prispieť, prispievať",
	example: "She contributed valuable ideas to the discussion.",
	exampleTranslation: "Prispela hodnotnými nápadmi do diskusie.",
	explanation:
		"to give (something, such as time, knowledge, or resources) to a common purpose or for the benefit of others, often as part of a group effort",
	image: "https://wiki.openmindsclub.net/contribute-to-openwiki/thumbnail.jpg",
});
const revealed = ref(false);
const answered = ref(false);
const animState = ref("idle");
const scrollable = ref(null);

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
}
</script>

<!-- 
insp: https://dribbble.com/shots/10827971-Vocabulary-App
-->
