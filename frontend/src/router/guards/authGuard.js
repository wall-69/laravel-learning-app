import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";

export default async function authGuard(to, from, next) {
	const { authenticated } = storeToRefs(useAuthStore());

	if (authenticated.value) {
		return next();
	}

	return next({ name: "login" });
}
