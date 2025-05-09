<template>
	<div
		class="bg-secondary-300 text-secondary-content-300 flex flex-col flex-1 gap-3 p-4 pb-5 rounded-md">
		<div class="flex gap-1">
			<i class="bx bx-trending-up bx-md text-primary-200"></i>
			<div class="flex flex-col">
				<h3 class="lg:text-2xl text-xl">Your statistics</h3>
			</div>
		</div>

		<ul>
			<li class="font-bold">
				Streak:
				<span class="font-normal"
					>{{ streak }} {{ pluralize("day", streak) }}</span
				>
			</li>
			<li class="font-bold">
				Words: <span class="font-normal">{{ words }}</span>
			</li>
			<li class="font-bold">
				Words packs: <span class="font-normal">{{ wordPacks }}</span>
			</li>
			<li class="font-bold">
				Paths: <span class="font-normal">{{ paths }}</span>
			</li>
		</ul>
	</div>
</template>
<script setup>
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref } from "vue";
import pluralize from "pluralize";

// Lifecycle
onMounted(async () => {
	await loadStatistics();
});

// Variables
const streak = ref(0);
const words = ref(0);
const wordPacks = ref(0);
const paths = ref(0);

// Functions
async function loadStatistics() {
	await handleRequest({
		request: () => axios.get("/api/statistics/user"),
		successCallback: async (response) => {
			streak.value = response.data.streak;
			words.value = response.data.words;
			wordPacks.value = response.data.word_packs;
			paths.value = response.data.paths;
		},
	});
}
</script>
