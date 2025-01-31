import useAuth from "@/composables/useAuth";

export default function adminGuard(to, from, next) {
	const { user, authenticated } = useAuth();

	if (authenticated.value && user.value.is_admin) {
		return next();
	}

	return next({ name: "learning" });
}
