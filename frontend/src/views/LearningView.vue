<template>
	<CustomHeader></CustomHeader>

	<main
		class="md:p-16 lg:justify-center lg:gap-14 xl:gap-20 2xl:gap-28 lg:flex-row flex flex-col flex-1 gap-8 p-2">
		<!-- Main section -->
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
	</main>

	<CustomFooter></CustomFooter>
</template>

<script setup>
import CustomHeader from "@/components/Header.vue";
import CustomFooter from "@/components/Footer.vue";
import Welcome from "@/components/Welcome.vue";
import RevisitWordPacks from "@/components/RevisitWordPacks.vue";
import ContinuePaths from "@/components/ContinuePaths.vue";
import DailyReview from "@/components/DailyReview.vue";
import YourStatistics from "@/components/YourStatistics.vue";
</script>
