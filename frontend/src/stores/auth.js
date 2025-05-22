import { defineStore } from "pinia";
import { ref } from "vue";

export const useAuthStore = defineStore(
	"auth",
	() => {
		const authenticated = ref(false);
		const user = ref({});

		return {
			authenticated,
			user,
		};
	},
	{
		persist: true,
	}
);
