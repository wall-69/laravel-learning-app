<template>
	<CustomHeader></CustomHeader>

	<main
		class="md:p-16 md:justify-between md:flex-row flex flex-col items-start flex-1 gap-8 p-8">
		<section class="flex flex-col items-start justify-center gap-8">
			<Welcome></Welcome>
			<Revisit></Revisit>
		</section>
		<section class="lg:block hidden">
			<DailyReview></DailyReview>
		</section>
	</main>

	<CustomFooter></CustomFooter>
</template>

<script setup>
import CustomHeader from "@/components/Header.vue";
import CustomFooter from "@/components/Footer.vue";
import Welcome from "@/components/Welcome.vue";
import Revisit from "@/components/Revisit.vue";
import DailyReview from "@/components/DailyReview.vue";
</script>
