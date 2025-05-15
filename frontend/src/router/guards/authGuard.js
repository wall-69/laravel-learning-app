import useAuth from "@/composables/useAuth";

export default async function authGuard(to, from, next) {
	const { attempt, authenticated } = useAuth();

	// TODO: replace with something better?
	await attempt();
	if (authenticated.value) {
		return next();
	}

	return next({ name: "login" });
}
