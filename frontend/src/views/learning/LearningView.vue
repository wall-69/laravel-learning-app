<template>
	<section class="flex flex-col justify-center gap-8">
		<Welcome></Welcome>
		<div class="sm:grid-cols-2 lg:flex grid grid-cols-1 gap-4">
			<div ref="smallSlot" class="lg:hidden block"></div>
			<YourStatistics></YourStatistics>
		</div>
		<RevisitWordPacks></RevisitWordPacks>
		<ContinuePaths></ContinuePaths>
	</section>

	<!-- Sidebar placeholder -->
	<section class="lg:block top-24 sticky self-start hidden">
		<div ref="largeSlot">
			<DailyReview ref="dailyReview"></DailyReview>
		</div>
	</section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import Welcome from "@/components/Welcome.vue";
import RevisitWordPacks from "@/components/RevisitWordPacks.vue";
import ContinuePaths from "@/components/ContinuePaths.vue";
import DailyReview from "@/components/DailyReview.vue";
import YourStatistics from "@/components/YourStatistics.vue";

// Lifecycle
onMounted(() => {
	moveDailyReview();

	window.addEventListener("resize", moveDailyReview);
});

onBeforeUnmount(() => {
	window.removeEventListener("resize", moveDailyReview);
});

// Variables
const dailyReview = ref(null);
const smallSlot = ref(null);
const largeSlot = ref(null);

// Functions
function moveDailyReview() {
	if (!dailyReview.value || !smallSlot.value || !largeSlot.value) return;

	const componentEl = dailyReview.value.$el;
	const target = window.innerWidth >= 1024 ? largeSlot.value : smallSlot.value;

	if (componentEl.parentNode !== target) {
		target.appendChild(componentEl);
	}
}
</script>
