<template>
	<CustomHeader></CustomHeader>

	<main
		class="md:p-16 lg:justify-center lg:gap-14 xl:gap-20 2xl:gap-28 lg:flex-row flex flex-col flex-1 gap-8 p-2">
		<!-- Main section -->
		<RouterView :key="$route.fullPath"></RouterView>
	</main>

	<CustomFooter></CustomFooter>
</template>

<script setup>
import CustomHeader from "@/components/Header.vue";
import CustomFooter from "@/components/Footer.vue";
</script>
