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

	const login = (data) => {
		return axios.post("/api/login", data);
	};

	const logout = () => {
		return axios.post("/api/logout");
	};

	const register = (data) => {
		return axios.post("/api/users", data);
	};

	// const register = async (data) => {
	// 	try {
	// 		let response = await axios.post("/api/users", data);

	// 		router.replace({ name: "login" });

	// 		return response;
	// 	} catch (ex) {
	// 		throw ex;
	// 	}
	// };

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
