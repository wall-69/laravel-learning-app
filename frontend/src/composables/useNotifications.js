import { computed, reactive, ref } from "vue";

const state = reactive({
	nextId: 1,
	notifications: [],
});

export default function useNotificiations() {
	const notifications = computed(() => state.notifications);
	const nextId = computed(() => state.nextId);

	const addNotification = ({ type, message }) => {
		if (!type in ["success", "warning", "error"]) {
			type = "warning";
		}

		state.notifications.push({
			id: nextId.value,
			type: type,
			message: message,
		});
		state.nextId += 1;
	};

	const removeNotification = (id) => {
		state.notifications = state.notifications.filter((notification) => {
			return notification.id != id;
		});
	};

	return {
		notifications,

		addNotification,
		removeNotification,
	};
}
