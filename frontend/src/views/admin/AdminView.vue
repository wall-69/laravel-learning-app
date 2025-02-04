<template>
	<main class="flex flex-1">
		<!-- Sidebar -->
		<section></section>

		<!-- Main section -->
		<section>
			<RouterView></RouterView>
		</section>
	</main>
</template>

<script setup>
import { RouterView } from "vue-router";
</script>
