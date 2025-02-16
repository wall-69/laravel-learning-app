import { createRouter, createWebHistory } from "vue-router";

import HomeView from "../views/HomeView.vue";
import LearningView from "../views/LearningView.vue";
import RegisterView from "@/views/RegisterView.vue";
import LoginView from "@/views/LoginView.vue";

import authGuard from "./guards/authGuard";
import guestGuard from "./guards/guestGuard";
import adminGuard from "./guards/adminGuard";

import AdminView from "@/views/admin/AdminView.vue";
import AdminHomeView from "@/views/admin/AdminHomeView.vue";
import AdminUsersView from "@/views/admin/AdminUsersView.vue";
import AdminAdminsView from "@/views/admin/AdminAdminsView.vue";
import AdminWordPacksView from "@/views/admin/AdminWordPacksView.vue";
import AdminPathsView from "@/views/admin/AdminPathsView.vue";

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
			component: AdminView,
			beforeEnter: [adminGuard],
			children: [
				{
					path: "",
					name: "admin",
					component: AdminHomeView,
				},
				{
					path: "users",
					name: "admin-users",
					component: AdminUsersView,
					children: [
						{
							path: "create",
							name: "admin-users-create",
						},
						{
							path: "edit/:id",
							name: "admin-users-edit",
						},
					],
				},
				{
					path: "admins",
					name: "admin-admins",
					component: AdminAdminsView,
					children: [
						{
							path: "create",
							name: "admin-admins-create",
						},
						{
							path: "edit/:id",
							name: "admin-admins-edit",
						},
					],
				},
				{
					path: "word-packs",
					name: "admin-word-packs",
					component: AdminWordPacksView,
					children: [
						{
							path: "create",
							name: "admin-word-packs-create",
						},
						{
							path: "edit/:id",
							name: "admin-word-packs-edit",
						},
					],
				},
				{
					path: "learning-paths",
					name: "admin-learning-paths",
					component: AdminPathsView,
				},
			],
		},
	],
});

export default router;
