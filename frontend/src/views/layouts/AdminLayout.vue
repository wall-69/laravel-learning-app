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
				<i
					v-if="sideBarExtended"
					class="bx bxs-chevron-left bx-sm flex text-gray-900"></i>
				<i v-else class="bx bxs-chevron-right bx-sm flex text-gray-900"></i>
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
						class="hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="bx bxs-home bx-md text-primary-300 flex"></i>
						<span v-if="sideBarExtended" class="text-nowrap hover:underline">
							Home
						</span>
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
						class="hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="bx bxs-group bx-md text-primary-300 flex"></i>
						<span v-if="sideBarExtended" class="text-nowrap hover:underline">
							Users
						</span>
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
						class="hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="bx bxs-wrench bx-md text-primary-300 flex"></i>
						<span v-if="sideBarExtended" class="text-nowrap hover:underline">
							Admins
						</span>
					</RouterLink>
				</li>
				<!-- Words -->
				<li class="text-primary-300 relative w-full text-lg">
					<div
						class="bg-primary-300 top-1 absolute w-1 h-8"
						:class="{
							hidden: $route.name != 'admin-words',
						}"></div>
					<RouterLink
						:to="{ name: 'admin-words' }"
						class="hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="bx bxs-data bx-md text-primary-300 flex"></i>
						<span v-if="sideBarExtended" class="text-nowrap hover:underline">
							Words
						</span>
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
						class="hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="bx bxs-customize bx-md text-primary-300 flex"></i>
						<span v-if="sideBarExtended" class="text-nowrap hover:underline">
							Word packs
						</span>
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
						class="hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="bx bxs-flag bx-md text-primary-300 flex"></i>
						<span v-if="sideBarExtended" class="text-nowrap hover:underline">
							Learning paths
						</span>
					</RouterLink>
				</li>
				<!-- Log out -->
				<li class="text-primary-300 relative w-full text-lg">
					<button
						@click="handleLogout"
						class="hover:cursor-pointer flex items-center gap-1 px-4">
						<i class="bx bxs-log-out bx-md text-primary-300 flex"></i>
						<span v-if="sideBarExtended" class="text-nowrap hover:underline">
							Log out
						</span>
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
