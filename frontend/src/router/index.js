import { createRouter, createWebHistory } from "vue-router";

import HomeView from "../views/HomeView.vue";
import RegisterView from "@/views/RegisterView.vue";
import LoginView from "@/views/LoginView.vue";
import ForgotPasswordView from "@/views/ForgotPasswordView.vue";
import ResetPasswordView from "@/views/ResetPasswordView.vue";

import LearningLayout from "../views/layouts/LearningLayout.vue";
import ReviewView from "@/views/learning/ReviewView.vue";
import LearningView from "@/views/learning/LearningView.vue";
import WordPacksView from "@/views/learning/WordPacksView.vue";

import WordsView from "@/views/user/words/WordsView.vue";
import WordCreateView from "@/views/user/words/WordCreateView.vue";
import ProfileView from "@/views/user/ProfileView.vue";

import authGuard from "./guards/authGuard";
import guestGuard from "./guards/guestGuard";
import adminGuard from "./guards/adminGuard";

import AdminLayout from "@/views/layouts/AdminLayout.vue";
import AdminHomeView from "@/views/admin/AdminHomeView.vue";
import AdminUsersView from "@/views/admin/AdminUsersView.vue";
import AdminAdminsView from "@/views/admin/AdminAdminsView.vue";
import AdminWordsView from "@/views/admin/AdminWordsView.vue";
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
			component: LearningLayout,
			beforeEnter: [authGuard],
			children: [
				{
					path: "",
					name: "learning",
					component: LearningView,
				},
				{
					path: "review",
					name: "review",
					component: ReviewView,
				},
				{
					path: "/word-packs",
					name: "word-packs",
					component: WordPacksView,
				},
				{
					path: "/paths",
					name: "paths",
					component: null,
				},
				{
					path: "/words",
					children: [
						{
							path: "",
							name: "words",
							component: WordsView,
						},
						{
							name: "words-create",
							path: "create",
							component: WordCreateView,
						},
					],
				},
				{
					path: "/profile",
					name: "profile",
					component: ProfileView,
				},
			],
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
			component: ForgotPasswordView,
			beforeEnter: [guestGuard],
		},
		{
			path: "/reset-password/:token",
			name: "reset-password",
			component: ResetPasswordView,
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

		// Admin
		{
			path: "/admin",
			component: AdminLayout,
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
					path: "words",
					name: "admin-words",
					component: AdminWordsView,
					children: [
						{
							path: "create",
							name: "admin-words-create",
						},
						{
							path: "edit/:id",
							name: "admin-words-edit",
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
					path: "paths",
					name: "admin-paths",
					component: AdminPathsView,
					children: [
						{
							path: "create",
							name: "admin-paths-create",
						},
						{
							path: "edit/:id",
							name: "admin-paths-edit",
						},
					],
				},
			],
		},
	],
});

export default router;
