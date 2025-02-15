import useAuth from "@/composables/useAuth";

export default function adminGuard(to, from, next) {
	const { user, authenticated } = useAuth();

	if (authenticated.value && user.value.admin) {
		return next();
	}

	return next({ name: "learning" });
}
