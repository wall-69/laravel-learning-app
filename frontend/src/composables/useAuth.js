import { computed, reactive, ref } from "vue";
import axios from "axios";
import { handleRequest } from "@/utils/requestWrapper";
import router from "@/router";

const state = reactive({
	authenticated: false,
	user: {},
});

export default function useAuth() {
	const authenticated = computed(() => state.authenticated);
	const user = computed(() => state.user);

	const setAuthenticated = (authenticated) => {
		state.authenticated = authenticated;
	};

	const setUser = (user) => {
		state.user = user;
	};

	async function attempt() {
		await handleRequest({
			request: () => axios.get("/api/user"),
			successCallback: async (response) => {
				setAuthenticated(true);
				setUser(response.data.user);
			},
			failCallback: async (response) => {
				setAuthenticated(false);
				setUser({});
			},
		});
	}

	async function login(data, errors) {
		await handleRequest({
			request: (data) => axios.post("/api/login", data),
			requestData: data,
			successCallback: async (response) => {
				setAuthenticated(true);
				setUser(response.data.user);

				router.replace({ name: "learning" });
			},
			errors: errors,
		});
	}

	async function logout() {
		await handleRequest({
			request: () => axios.post("/api/logout"),
			successCallback: async (response) => {
				setAuthenticated(false);
				setUser({});
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
		authenticated,
		user,

		setAuthenticated,
		setUser,

		attempt,
		login,
		logout,
		register,
	};
}
