<template>
	<header
		class="bg-secondary-500 border-primary-300 sticky top-0 px-10 py-5 border-b-4">
		<nav class="flex justify-between">
			<h1 class="text-primary-300 flex items-center text-3xl">DailyVocab</h1>

			<div class="flex gap-4">
				<template v-if="authenticated">
					<!-- If user is on homepage -->
					<RouterLink
						v-if="$route.name == 'home'"
						:to="{ name: 'learning' }"
						class="btn-primary">
						DASHBOARD
					</RouterLink>

					<!-- If user is in learning dashboard -->
					<template v-else>
						<ul class="flex items-center gap-6 text-white">
							<li>
								<a
									href=""
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'learning',
									}"
									>Dashboard</a
								>
							</li>
							<li>
								<a
									href=""
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'blog',
									}"
									>Blog</a
								>
							</li>
							<li>
								<a
									href=""
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium':
											$route.name == 'learning-paths',
									}"
									>Learning paths</a
								>
							</li>
							<li>
								<a
									href=""
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'word-packs',
									}"
									>Word packs</a
								>
							</li>
							<li>
								<button @click="handleLogout">LOG OUT</button>
							</li>
							<li>
								<i
									class="bg-primary-300 hover:cursor-pointer flex items-center p-1.5 rounded-full">
									<box-icon
										name="user"
										type="solid"
										color="#08144D"
										size="md"></box-icon>
								</i>
							</li>
						</ul>
					</template>
				</template>
				<template v-else>
					<RouterLink :to="{ name: 'login' }" class="btn-primary">
						LOGIN
					</RouterLink>
					<RouterLink :to="{ name: 'register' }" class="btn-primary">
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
	} catch (ex) {}
}
</script>
