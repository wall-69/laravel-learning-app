import useAuth from "@/composables/useAuth";

export default function authGuard(to, from, next) {
	const { authenticated } = useAuth();

	if (!authenticated.value) {
		return next();
	}

	return next({ name: "learning" });
}
