import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";

export default async function guestGuard(to, from, next) {
	const { authenticated } = storeToRefs(useAuthStore());

	if (!authenticated.value) {
		return next();
	}

	return next({ name: "learning" });
}
