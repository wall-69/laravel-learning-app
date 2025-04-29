<template>
	<section class="flex flex-col justify-center gap-8">
		<Welcome></Welcome>
		<div class="sm:grid-cols-2 lg:flex grid grid-cols-1 gap-4">
			<DailyReview class="lg:hidden block"></DailyReview>
			<YourStatistics></YourStatistics>
		</div>
		<RevisitWordPacks></RevisitWordPacks>
		<ContinuePaths></ContinuePaths>
	</section>

	<!-- Sidebar -->
	<section class="lg:block top-24 sticky self-start hidden">
		<DailyReview></DailyReview>
	</section>
</template>
<script setup>
import Welcome from "@/components/Welcome.vue";
import RevisitWordPacks from "@/components/RevisitWordPacks.vue";
import ContinuePaths from "@/components/ContinuePaths.vue";
import DailyReview from "@/components/DailyReview.vue";
import YourStatistics from "@/components/YourStatistics.vue";
</script>
