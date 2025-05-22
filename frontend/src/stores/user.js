import { defineStore } from "pinia";
import { ref } from "vue";

export const useUserStore = defineStore(
	"user",
	() => {
		const userWordPacks = ref([]);

		return {
			userWordPacks,
		};
	},
	{
		persist: true,
	}
);
