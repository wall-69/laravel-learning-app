<template>
	<!-- Toast notifications -->
	<div
		class="left-1/2 md:w-96 w-72 absolute top-0 z-10 flex flex-col gap-2 mt-6 -translate-x-1/2">
		<Toast
			v-for="notification in notifications"
			:key="notification.id"
			:notification="notification"></Toast>
	</div>

	<!-- Router view -->
	<RouterView />
</template>

<script setup>
import { RouterView } from "vue-router";
import Toast from "@/components/notifications/Toast.vue";
import useNotifications from "@/composables/useNotifications";

const { notifications } = useNotifications();
</script>
