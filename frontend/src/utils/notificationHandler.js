import useNotificiations from "@/composables/useNotifications";

export async function handleNotifications(responseNotifications) {
	const { addNotification } = useNotificiations();

	for (const type in responseNotifications) {
		for (const message in responseNotifications[type]) {
			addNotification({
				type: type,
				message: responseNotifications[type][message],
			});
		}
	}
}
