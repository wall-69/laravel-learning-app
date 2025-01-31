export async function handleFormErrors(errors, responseErrors) {
	Object.keys(responseErrors).forEach((field) => {
		// Update only fields which are in the errors object
		if (errors.hasOwnProperty(field)) {
			errors[field] = responseErrors[field][0];
		}
	});
}
