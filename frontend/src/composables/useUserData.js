import { computed, reactive } from "vue";

const state = reactive({
	userWordPacks: [],
});

export default function useUserData() {
	const userWordPacks = computed(() => state.userWordPacks);

	function setUserWordPacks(userWordPacks) {
		state.userWordPacks = userWordPacks;
	}

	return {
		userWordPacks,

		setUserWordPacks,
	};
}
