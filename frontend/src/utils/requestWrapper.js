import { handleFormErrors } from "./errorHandler";
import { handleNotifications } from "./notificationHandler";

// TODO: document this
export async function handleRequest({
	request,
	requestData = {},
	successCallback = async () => {},
	failCallback = async () => {},
	errors = {},
}) {
	// Clear existing errors
	for (let key in errors) {
		errors[key] = "";
	}

	// Make the request with args as parameters
	try {
		const response = await request(requestData);

		// Handle notifications
		const responseNotifications = response.data.notifications;
		handleNotifications(responseNotifications);

		// Call the success callback
		await successCallback(response);

		return {
			success: true,
			response: response,
		};
	} catch (ex) {
		// Call the fail callback
		await failCallback(ex);

		if (!ex.response) {
			return {
				success: false,
				response: null,
			};
		}

		// Handle form errors
		const responseErrors = ex.response.data.errors || {};
		handleFormErrors(errors, responseErrors);

		return {
			success: false,
			response: ex.response,
		};
	}
}
