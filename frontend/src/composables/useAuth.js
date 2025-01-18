import { computed, reactive, ref } from "vue";
import axios from "axios";

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

	const attempt = async () => {
		try {
			let response = await axios.get("/api/user");

			setAuthenticated(true);
			setUser(response.data);
		} catch (e) {
			setAuthenticated(false);
			setUser({});
		}
	};

	// TODO
	const login = async (data) => {
		try {
			await axios.post("/login", credentials);
		} catch (e) {
			return Promise.reject(e.response.data.errors);
		}
	};

	const register = async (data) => {
		try {
		} catch (e) {
			return Promise.reject(e.response.data.errors);
		}
	};

	return {
		authenticated,
		user,

		attempt,
		login,
		register,
	};
}
