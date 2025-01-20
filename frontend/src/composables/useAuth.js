import { computed, reactive, ref } from "vue";
import axios from "axios";
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

	const attempt = async () => {
		try {
			let response = await axios.get("/api/user");

			setAuthenticated(true);
			setUser(response.data.user);

			return response;
		} catch (ex) {
			setAuthenticated(false);
			setUser({});
		}
	};

	const login = async (data) => {
		try {
			let response = await axios.post("/api/login", data);

			setAuthenticated(true);
			setUser(response.data.user);

			router.replace({ name: "learning" });

			return response;
		} catch (ex) {
			throw ex;
		}
	};

	const logout = async () => {
		try {
			let response = await axios.post("/api/logout");

			setAuthenticated(false);
			setUser({});

			router.replace({ name: "home" });

			return response;
		} catch (ex) {
			throw ex;
		}
	};

	const register = async (data) => {
		try {
			let response = await axios.post("/api/users", data);

			router.replace({ name: "login" });

			return response;
		} catch (ex) {
			throw ex;
		}
	};

	return {
		authenticated,
		user,

		attempt,
		login,
		logout,
		register,
	};
}
