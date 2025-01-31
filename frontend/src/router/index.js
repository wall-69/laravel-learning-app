import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LearningView from "../views/LearningView.vue";
import RegisterView from "@/views/RegisterView.vue";
import LoginView from "@/views/LoginView.vue";
import authGuard from "./authGuard";
import guestGuard from "./guestGuard";
import AdminView from "@/views/admin/AdminView.vue";
import adminGuard from "./adminGuard";

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
			beforeEnter: [authGuard],
		},
		{
			path: "/register",
			name: "register",
			component: RegisterView,
			beforeEnter: [guestGuard],
		},
		{
			path: "/login",
			name: "login",
			component: LoginView,
			beforeEnter: [guestGuard],
		},
		{
			path: "/forgot-password",
			name: "forgot-password",
			component: null,
			beforeEnter: [guestGuard],
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
		{
			path: "/word-packs",
			name: "word-packs",
			component: null,
		},
		{
			path: "/learning-paths",
			name: "learning-paths",
			component: null,
		},

		// Admin
		{
			path: "/admin",
			name: "admin",
			component: AdminView,
			beforeEnter: [adminGuard],
		},
	],
});

export default router;
