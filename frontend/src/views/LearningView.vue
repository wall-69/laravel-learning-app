<template>
	<CustomHeader></CustomHeader>

	<main
		class="md:p-16 md:justify-between md:flex-row md:items-start flex flex-col items-center flex-1 p-8">
		<section
			class="md:items-start flex flex-col items-center justify-center gap-8">
			<Welcome></Welcome>
			<Revisit></Revisit>
		</section>
		<section></section>
	</main>

	<CustomFooter></CustomFooter>
</template>

<script setup>
import CustomHeader from "@/components/Header.vue";
import CustomFooter from "@/components/Footer.vue";
import Welcome from "@/components/Welcome.vue";
import Revisit from "@/components/Revisit.vue";
</script>
