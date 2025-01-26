<template>
	<header
		class="bg-secondary-500 border-primary-300 sticky top-0 z-10 px-10 py-5 border-b-4">
		<nav class="flex justify-between">
			<h1 class="text-primary-300 flex items-center text-3xl">DailyVocab</h1>

			<div class="flex gap-4">
				<!-- User is logged in -->
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
							<!-- Dashboard -->
							<li>
								<RouterLink
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'learning',
									}">
									Dashboard
								</RouterLink>
							</li>

							<!-- Blog -->
							<li>
								<RouterLink
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'blog',
									}">
									Blog
								</RouterLink>
							</li>

							<!-- Learning paths -->
							<li>
								<RouterLink
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'paths',
									}">
									Learning paths
								</RouterLink>
							</li>

							<!-- Word packs -->
							<li>
								<RouterLink
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'word-packs',
									}">
									Word packs
								</RouterLink>
							</li>

							<!-- User dropdown button -->
							<li
								@click="userDropdownVisible = !userDropdownVisible"
								class="relative">
								<i
									class="hover:cursor-pointer flex items-center p-1.5 rounded-full transition-colors duration-300"
									:class="{
										'bg-primary-300': !userDropdownVisible,
										'bg-secondary-500': userDropdownVisible,
									}">
									<box-icon
										v-if="userDropdownVisible"
										name="user"
										type="solid"
										color="#38DFF5"
										size="md"></box-icon>
									<box-icon
										v-else
										name="user"
										type="solid"
										color="#08144D"
										size="md"></box-icon>
								</i>

								<!-- User dropdown -->
								<Transition name="user-dropdown">
									<div
										v-show="userDropdownVisible"
										class="border-primary-300 bg-secondary-500 absolute mt-1.5 rounded-md z-50 right-0 border-2">
										<ul class="w-max flex flex-col gap-4 m-2">
											<!-- My profile -->
											<li class="flex items-center gap-1">
												<i class="flex items-center">
													<box-icon
														name="user-pin"
														type="solid"
														color="#38DFF5"></box-icon>
												</i>
												<RouterLink
													class="text-primary-300 hover:text-primary-500 transition-colors">
													My profile
												</RouterLink>
											</li>

											<!-- Log out -->
											<li class="flex items-center gap-1">
												<i class="flex items-center">
													<box-icon
														name="log-out"
														type="solid"
														color="#38DFF5"></box-icon>
												</i>
												<button
													@click="handleLogout"
													class="text-primary-300 hover:text-primary-500 transition-colors">
													Log out
												</button>
											</li>
										</ul>
									</div>
								</Transition>
							</li>

							<!-- Mobile dropdown button -->
							<li @click="mobileDropdownVisible = true">
								<i
									class="bg-primary-300 lg:hidden hover:cursor-pointer flex items-center p-1.5 rounded-full">
									<box-icon name="menu" color="#08144D" size="md"></box-icon>
								</i>
							</li>
						</ul>
					</template>
				</template>

				<!-- Else - user is not logged in -->
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
import { ref, Transition } from "vue";

const { authenticated, logout } = useAuth();

async function handleLogout() {
	try {
		await logout();
	} catch (ex) {}
}

const userDropdownVisible = ref(false);
const mobileDropdownVisible = ref(false);
</script>
<style>
.user-dropdown-enter-active {
	animation: bounce-in 0.3s;
}
.user-dropdown-leave-active {
	animation: bounce-in 0.15s reverse;
}
@keyframes bounce-in {
	0% {
		transform: scale(0);
	}
	100% {
		transform: scale(1);
	}
}
</style>
