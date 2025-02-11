<template>
	<main class="flex flex-1">
		<!-- Sidebar -->
		<section
			class="border-primary-300 bg-secondary-500 min-w-max sticky top-0 h-screen border-r-2">
			<button
				@click="sideBarExtended = !sideBarExtended"
				class="bg-primary-300 top-8 hover:bg-primary-400 absolute right-0 transition-all translate-x-1/2 rounded-md">
				<i class="flex items-center justify-center">
					<box-icon
						v-if="sideBarExtended"
						name="chevron-left"
						type="solid"
						color="#1B1B1B"
						size="sm"></box-icon>
					<box-icon
						v-else
						name="chevron-right"
						type="solid"
						color="#1B1B1B"
						size="sm"></box-icon>
				</i>
			</button>

			<ul class="flex flex-col items-start gap-6 mt-20">
				<!-- Home -->
				<li class="text-primary-300 relative w-full text-lg">
					<div
						class="bg-primary-300 top-1 absolute w-1 h-8"
						:class="{
							hidden: $route.name != 'admin',
						}"></div>
					<RouterLink
						:to="{ name: 'admin' }"
						class="hover:underline hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="flex items-start justify-start">
							<box-icon
								name="home"
								type="solid"
								color="#38DFF5"
								size="md"></box-icon>
						</i>
						<span v-if="sideBarExtended">Home</span>
					</RouterLink>
				</li>
				<!-- Users -->
				<li class="text-primary-300 relative w-full text-lg">
					<div
						class="bg-primary-300 top-1 absolute w-1 h-8"
						:class="{
							hidden: $route.name != 'admin-users',
						}"></div>
					<RouterLink
						:to="{ name: 'admin-users' }"
						class="hover:underline hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="flex items-start justify-start">
							<box-icon
								name="group"
								type="solid"
								color="#38DFF5"
								size="md"></box-icon>
						</i>
						<span v-if="sideBarExtended">Users</span>
					</RouterLink>
				</li>
				<!-- Admins -->
				<li class="text-primary-300 relative w-full text-lg">
					<div
						class="bg-primary-300 top-1 absolute w-1 h-8"
						:class="{
							hidden: $route.name != 'admin-admins',
						}"></div>
					<RouterLink
						:to="{ name: 'admin-admins' }"
						class="hover:underline hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="flex items-start justify-start">
							<box-icon
								name="wrench"
								type="solid"
								color="#38DFF5"
								size="md"></box-icon>
						</i>
						<span v-if="sideBarExtended">Admins</span>
					</RouterLink>
				</li>
				<!-- Word packs -->
				<li class="text-primary-300 relative w-full text-lg">
					<div
						class="bg-primary-300 top-1 absolute w-1 h-8"
						:class="{
							hidden: $route.name != 'admin-word-packs',
						}"></div>
					<RouterLink
						:to="{ name: 'admin-word-packs' }"
						class="hover:underline hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="flex items-start justify-start">
							<box-icon
								name="customize"
								type="solid"
								color="#38DFF5"
								size="md"></box-icon>
						</i>
						<span v-if="sideBarExtended">Word packs</span>
					</RouterLink>
				</li>
				<!-- Paths -->
				<li class="text-primary-300 relative w-full text-lg">
					<div
						class="bg-primary-300 top-1 absolute w-1 h-8"
						:class="{
							hidden: $route.name != 'admin-learning-paths',
						}"></div>
					<RouterLink
						:to="{ name: 'admin-learning-paths' }"
						class="hover:underline hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="flex items-start justify-start">
							<box-icon
								name="flag"
								type="solid"
								color="#38DFF5"
								size="md"></box-icon>
						</i>
						<span v-if="sideBarExtended">Learning paths</span>
					</RouterLink>
				</li>
				<!-- Log out -->
				<li class="text-primary-300 relative w-full text-lg">
					<button
						@click="handleLogout"
						class="hover:underline hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="flex items-start justify-start">
							<box-icon
								name="log-out"
								type="solid"
								color="#38DFF5"
								size="md"></box-icon>
						</i>
						<span v-if="sideBarExtended">Log out</span>
					</button>
				</li>
			</ul>
		</section>

		<!-- Main section -->
		<RouterView :key="$route.fullPath"></RouterView>
	</main>
</template>

<script setup>
import useAuth from "@/composables/useAuth";
import router from "@/router";
import { handleRequest } from "@/utils/requestWrapper";
import { ref } from "vue";
import { RouterView } from "vue-router";

// Composables
const { setAuthenticated, setUser, logout } = useAuth();

// Variables
const sideBarExtended = ref(true);

// Functions
async function handleLogout() {
	// Make request to logout API endpoint
	await handleRequest({
		request: logout,
		successCallback: async (response) => {
			setAuthenticated(false);
			setUser({});

			router.replace({ name: "home" });
		},
	});
}
</script>
<style>
/* Sidebar */
.sidebar2-enter-active {
	animation: slide-down 0.3s;
}

@keyframes slide-down {
	0% {
		transform: translateX(-100%);
	}
	100% {
		transform: translateX(0);
	}
}
</style>
