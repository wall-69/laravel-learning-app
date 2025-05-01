import "./assets/main.css";
import axios from "axios";
import VCalendar from "v-calendar";
import "v-calendar/style.css";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import useAuth from "./composables/useAuth";

// Axios
axios.defaults.baseURL = "http://localhost:8000";
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
// Fetch CSRF cookie automatically, if none is set
axios.interceptors.request.use(
	async (config) => {
		// Prevent infinite loop
		if (config.url === "/api/csrf-cookie") {
			return config;
		}

		// If CSRF cookie is missing, fetch it
		if (!document.cookie.includes("XSRF-TOKEN")) {
			await axios.get("/api/csrf-cookie");
		}

		return config;
	},
	(error) => Promise.reject(error)
);

// First try to fetch the user
const { attempt } = useAuth();
await attempt();

// Create the Vue app
const app = createApp(App);

// Custom click-outside directive
app.directive("click-outside", {
	beforeMount(el, binding) {
		el.clickOutsideElement = (e) => {
			if (e.target != el && !el.contains(e.target)) {
				binding.value();
			}
		};

		document.body.addEventListener("click", el.clickOutsideElement);
	},

	beforeUnmount(el, binding) {
		document.body.removeEventListener("click", el.clickOutsideElement);
	},
});

// Custom prevent document scroll when
app.directive("hover-no-document-scroll", {
	beforeMount(el, binding) {
		el.preventDocumentScrollOnHover = (e) => {
			document.body.classList.add("no-scroll");
		};
		el.allowDocumentScrollOnHover = (e) => {
			document.body.classList.remove("no-scroll");
		};

		el.addEventListener("mouseover", el.preventDocumentScrollOnHover);
		el.addEventListener("mouseout", el.allowDocumentScrollOnHover);
	},

	beforeUnmount(el, binding) {
		el.removeEventListener("mouseover", el.preventDocumentScrollOnHover);
		el.removeEventListener("mouseout", el.allowDocumentScrollOnHover);
	},
});

app.use(router);
app.use(VCalendar);

app.mount("#app");
