<template>
	<header
		class="bg-secondary-500 border-primary-300 sticky top-0 z-20 px-10 py-5 border-b-4">
		<nav class="flex justify-between">
			<h1 class="text-primary-300 flex items-center text-3xl">DailyVocab</h1>

			<div class="flex gap-4">
				<!-- User is logged in -->
				<template v-if="authenticated">
					<!-- If user is on homepage -->
					<RouterLink
						v-if="$route.name == 'home'"
						:to="{ name: 'learning' }"
						class="btn-primary-cta">
						DASHBOARD
					</RouterLink>

					<!-- If user is in learning dashboard -->
					<template v-else>
						<ul class="flex items-center gap-6 text-white">
							<!-- Dashboard -->
							<li class="lg:block hidden">
								<RouterLink
									:to="{ name: 'learning' }"
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'learning',
									}">
									Dashboard
								</RouterLink>
							</li>

							<!-- Learning paths -->
							<li class="lg:block hidden">
								<RouterLink
									:to="{ name: 'paths' }"
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'paths',
									}">
									Learning paths
								</RouterLink>
							</li>

							<!-- Word packs -->
							<li class="lg:block hidden">
								<RouterLink
									:to="{ name: 'word-packs' }"
									class="hover:underline text-xl transition-all"
									:class="{
										'text-primary-400 font-medium': $route.name == 'word-packs',
									}">
									Word packs
								</RouterLink>
							</li>

							<!-- Admin -->
							<li v-if="user.admin" class="lg:block hidden">
								<RouterLink
									:to="{ name: 'admin' }"
									class="hover:underline text-xl transition-all">
									Admin
								</RouterLink>
							</li>

							<!-- User dropdown button -->
							<li class="relative">
								<i
									@click.prevent.stop="
										userDropdownVisible = !userDropdownVisible
									"
									class="hover:cursor-pointer flex items-center p-1.5 rounded-full transition-colors duration-300"
									:class="{
										'bg-primary-300': !userDropdownVisible,
										'bg-secondary-500': userDropdownVisible,
									}">
									<i
										v-if="userDropdownVisible"
										class="bx bxs-user bx-md text-primary-300"></i>
									<i v-else class="bx bxs-user bx-md text-secondary-500"></i>
								</i>

								<!-- User dropdown -->
								<Transition name="user-dropdown">
									<div
										v-show="userDropdownVisible"
										v-click-outside="handleUserDropdownClickOutside"
										class="border-primary-300 bg-secondary-500 absolute mt-1.5 rounded-md z-50 right-0 border-2">
										<ul class="w-max flex flex-col gap-4 m-2">
											<!-- My profile -->
											<li class="flex items-center gap-1">
												<i class="text-primary-300 bx bxs-user-pin bx-sm"></i>
												<RouterLink
													class="text-primary-300 hover:text-primary-500 transition-colors">
													My profile
												</RouterLink>
											</li>

											<!-- Log out -->
											<li class="flex items-center gap-1">
												<i class="text-primary-300 bx bxs-log-out bx-sm"> </i>
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
							<li
								@click.prevent="mobileDropdownVisible = !mobileDropdownVisible"
								class="lg:hidden block">
								<i
									class="hover:cursor-pointer flex items-center p-1.5 rounded-full transition-colors duration-300"
									:class="{
										'bg-primary-300': !mobileDropdownVisible,
										'bg-secondary-500': mobileDropdownVisible,
									}">
									<i
										v-if="mobileDropdownVisible"
										class="bx bx-x bx-md text-primary-300"></i>
									<i v-else class="bx bx-menu bx-md text-secondary-500"></i>
								</i>
							</li>
						</ul>
					</template>
				</template>

				<!-- Else - user is not logged in -->
				<template v-else>
					<RouterLink :to="{ name: 'login' }" class="btn-primary-cta">
						LOGIN
					</RouterLink>
					<RouterLink :to="{ name: 'register' }" class="btn-primary-cta">
						REGISTER
					</RouterLink>
				</template>
			</div>
		</nav>
	</header>

	<!-- Mobile dropdown -->
	<Transition name="mobile-dropdown">
		<div
			v-show="mobileDropdownVisible"
			class="bg-secondary-400 fixed w-screen top-[92px] left-0 h-screen-wo-nav z-10">
			<ul class="flex flex-col items-center gap-4 py-4">
				<!-- Dashboard -->
				<li class="flex items-center gap-1">
					<i class="bx bxs-dashboard bx-sm text-primary-300"></i>
					<RouterLink
						@click="mobileDropdownVisible = false"
						:to="{ name: 'learning' }"
						class="text-primary-300 hover:text-primary-500 text-2xl transition-colors">
						Dashboard
					</RouterLink>
				</li>

				<hr class="bg-secondary-100 w-full h-px" />

				<!-- Word packs -->
				<li class="flex items-center gap-1">
					<i class="bx bxs-customize bx-sm text-primary-300"></i>
					<RouterLink
						@click="mobileDropdownVisible = false"
						:to="{ name: 'word-packs' }"
						class="text-primary-300 hover:text-primary-500 text-2xl transition-colors">
						Word packs
					</RouterLink>
				</li>

				<hr class="bg-secondary-100 w-full h-px" />

				<!-- Learning paths -->
				<li class="flex items-center gap-1">
					<i class="bx bxs-flag bx-sm text-primary-300"></i>
					<RouterLink
						@click="mobileDropdownVisible = false"
						:to="{ name: 'paths' }"
						class="text-primary-300 hover:text-primary-500 text-2xl transition-colors">
						Learning paths
					</RouterLink>
				</li>
			</ul>
		</div>
	</Transition>
</template>
<script setup>
import { RouterLink } from "vue-router";
import useAuth from "@/composables/useAuth";
import { ref, watch } from "vue";

// Composables
const { user, authenticated, logout } = useAuth();

// Variables
const userDropdownVisible = ref(false);
const mobileDropdownVisible = ref(false);

// Functions
async function handleLogout() {
	// Make request to logout API endpoint
	await logout();
}
function handleUserDropdownClickOutside() {
	if (userDropdownVisible.value) {
		userDropdownVisible.value = false;
	}
}

// Watchers
// Make document not scrollable when mobile dropdown is visible
watch(
	() => mobileDropdownVisible.value,
	(newVisible, oldVisible) => {
		if (newVisible) {
			document.body.classList.add("no-scroll");
		} else {
			document.body.classList.remove("no-scroll");
		}
	}
);
</script>
<style>
/* User dropdown */
.user-dropdown-enter-active {
	animation: bounce-in 0.3s;
}
.user-dropdown-leave-active {
	animation: bounce-in 0.05s reverse;
}
@keyframes bounce-in {
	0% {
		transform: scale(0);
	}
	100% {
		transform: scale(1);
	}
}

/* Mobile dropdown */
.mobile-dropdown-enter-active {
	animation: slide-down 0.3s;
}

@keyframes slide-down {
	0% {
		transform: translateY(-100%);
	}
	100% {
		transform: translateY(0);
	}
}
</style>
