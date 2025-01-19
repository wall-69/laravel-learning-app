<template>
	<header
		class="bg-secondary-500 border-primary-300 sticky top-0 px-10 py-5 border-b-4">
		<nav class="flex justify-between">
			<h1 class="text-primary-300 flex items-center text-3xl">DailyVocab</h1>

			<div class="flex gap-4">
				<template v-if="authenticated">
					<RouterLink
						v-if="$route.name == 'home'"
						:to="{ name: 'learning' }"
						class="btn-primary">
						DASHBOARD
					</RouterLink>
					<button @click="handleLogout" class="btn-primary">LOG OUT</button>
				</template>
				<template v-else>
					<RouterLink
						v-if="!authenticated"
						:to="{ name: 'login' }"
						class="btn-primary">
						LOGIN
					</RouterLink>
					<RouterLink
						v-if="!authenticated"
						:to="{ name: 'register' }"
						class="btn-primary">
						REGISTER
					</RouterLink>
				</template>
			</div>
		</nav>
	</header>
</template>
<script setup>
import { RouterLink } from "vue-router";
import useAuth from "@/composables/useAuth";

const { authenticated, logout } = useAuth();

async function handleLogout() {
	try {
		await logout();
	} catch (e) {}
}
</script>
