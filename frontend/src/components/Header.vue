<template>
	<header
		class="bg-secondary-500 border-primary-300 sticky top-0 px-10 py-5 border-b-4">
		<nav class="flex justify-between">
			<h1 class="text-primary-300 flex items-center text-3xl">DailyVocab</h1>
			<RouterLink :to="{ name: 'register' }" class="btn-register-primary">
				REGISTER
			</RouterLink>
		</nav>
	</header>
</template>
<script setup>
import { RouterLink } from "vue-router";
</script>
