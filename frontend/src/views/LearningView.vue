<template>
	<CustomHeader></CustomHeader>

	<main
		class="md:p-16 md:justify-between md:flex-row flex flex-col items-start flex-1 gap-8 p-8">
		<!-- Main section -->
		<section class="flex flex-col justify-center gap-8">
			<Welcome></Welcome>
			<RevisitWordPacks></RevisitWordPacks>
			<ContinuePaths></ContinuePaths>
		</section>

		<!-- Sidebar -->
		<section class="lg:table top-24 sticky hidden">
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
</script>
