import { computed, reactive } from "vue";

const state = reactive({
	wordPacks: [],
});

export default function useUserData() {
	const wordPacks = computed(() => state.wordPacks);

	function setWordPacks(wordPacks) {
		state.wordPacks = wordPacks;
	}

	return {
		wordPacks,

		setWordPacks,
	};
}
