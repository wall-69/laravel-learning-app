import useAuth from "@/composables/useAuth";

export default async function adminGuard(to, from, next) {
	const { attempt, user, authenticated } = useAuth();

	// TODO: replace with something better?
	await attempt();
	if (authenticated.value && user.value.admin) {
		return next();
	}

	return next({ name: "learning" });
}
