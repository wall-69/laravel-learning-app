import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";

export default async function adminGuard(to, from, next) {
	const { authenticated, user } = storeToRefs(useAuthStore());

	if (authenticated.value && user.value.admin) {
		return next();
	}

	return next({ name: "learning" });
}
