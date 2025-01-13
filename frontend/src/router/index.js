import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LearningView from "../views/LearningView.vue";
import RegisterView from "@/views/RegisterView.vue";

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: "/",
			name: "home",
			component: HomeView,
		},
		{
			path: "/learning",
			name: "learning",
			component: LearningView,
		},
		{
			path: "/register",
			name: "register",
			component: RegisterView,
		},
		{
			path: "/login",
			name: "login",
			component: null,
		},
		{
			path: "/terms-of-service",
			name: "terms-of-service",
			component: null,
		},
		{
			path: "/privacy-policy",
			name: "privacy-policy",
			component: null,
		},
	],
});

export default router;
