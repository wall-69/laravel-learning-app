<template>
	<main class="flex flex-1">
		<!-- Sidebar -->
		<section
			class="border-primary-300 bg-secondary-500 sticky top-0 h-screen transition-all border-r-2"
			:class="{
				'w-[196px]': sideBarExtended,
				'w-[68px]': !sideBarExtended,
			}">
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
						<span v-if="sideBarExtended" class="text-nowrap">Home</span>
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
						<span v-if="sideBarExtended" class="text-nowrap">Users</span>
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
						<span v-if="sideBarExtended" class="text-nowrap">Admins</span>
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
						<span v-if="sideBarExtended" class="text-nowrap">Word packs</span>
					</RouterLink>
				</li>
				<!-- Paths -->
				<li class="text-primary-300 relative w-full text-lg">
					<div
						class="bg-primary-300 top-1 absolute w-1 h-8"
						:class="{
							hidden: $route.name != 'admin-paths',
						}"></div>
					<RouterLink
						:to="{ name: 'admin-paths' }"
						class="hover:underline hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="flex items-start justify-start">
							<box-icon
								name="flag"
								type="solid"
								color="#38DFF5"
								size="md"></box-icon>
						</i>
						<span v-if="sideBarExtended" class="text-nowrap">
							Learning paths
						</span>
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
						<span v-if="sideBarExtended" class="text-nowrap">Log out</span>
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
import { ref } from "vue";
import { RouterView } from "vue-router";

// Composables
const { logout } = useAuth();

// Variables
const sideBarExtended = ref(true);

// Functions
async function handleLogout() {
	// Make request to logout API endpoint
	await logout();
}
</script>
