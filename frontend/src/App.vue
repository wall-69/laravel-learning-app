<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
	<header v-if="$route.name != 'home'">
		<nav class="w-full bg-neutral-light p-2">
			<RouterLink :to="{ name: 'home' }" class="">Home</RouterLink>
			<RouterLink :to="{ name: 'learning' }" class="">Learning</RouterLink>
		</nav>
	</header>

	<RouterView />
</template>
