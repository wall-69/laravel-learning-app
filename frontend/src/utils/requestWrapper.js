import { handleFormErrors } from "./errorHandler";

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

		// Call the success callback
		await successCallback(response);

		return {
			success: true,
			response: response,
		};
	} catch (ex) {
		// Call the fail callback
		await failCallback();

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
