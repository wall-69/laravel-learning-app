import { computed, reactive } from "vue";
import axios from "axios";
import { handleRequest } from "@/utils/requestWrapper";
import router from "@/router";
import { useUserStore } from "@/stores/user";
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";

export default function useAuth() {
	const authStore = useAuthStore();
	const { authenticated, user } = storeToRefs(authStore);

	const userStore = useUserStore();
	const { userWordPacks } = storeToRefs(userStore);

	async function attempt() {
		await handleRequest({
			request: () => axios.get("/api/user"),
			successCallback: async (response) => {
				authenticated.value = true;
				user.value = response.data.user;

				userWordPacks.value = response.data.user.user_word_packs;
			},
			failCallback: async (response) => {
				authenticated.value = false;
				user.value = {};
			},
		});
	}

	async function login(data, errors) {
		await handleRequest({
			request: (data) => axios.post("/api/login", data),
			requestData: data,
			successCallback: async (response) => {
				await attempt();

				router.replace({ name: "learning" });
			},
			errors: errors,
		});
	}

	async function logout() {
		await handleRequest({
			request: () => axios.post("/api/logout"),
			successCallback: async (response) => {
				authenticated.value = false;
				user.value = {};

				userWordPacks.value = [];

				router.replace({ name: "home" });
			},
		});
	}

	async function register(data, errors) {
		await handleRequest({
			request: (data) => axios.post("/api/users", data),
			requestData: data,
			successCallback: async (response) => {
				router.replace({ name: "login" });
			},
			errors: errors,
		});
	}

	return {
		attempt,
		login,
		logout,
		register,
	};
}
