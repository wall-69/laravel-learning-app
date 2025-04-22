<template>
	<div
		class="flex justify-between gap-2 p-3 bg-green-300 rounded-md"
		:class="{
			'bg-green-300': notification.type == 'success',
			'bg-yellow-300': notification.type == 'warning',
			'bg-red-300': notification.type == 'error',
		}">
		<p
			:class="{
				'text-gray-100': notification.type != 'warning',
				'text-gray-800': notification.type == 'warning',
			}">
			{{ notification.message }}
		</p>

		<button
			class="hover:cursor-pointer flex items-center justify-center"
			@click="removeNotification(notification.id)">
			<i
				v-if="notification.type != 'warning'"
				class="bx bx-x bx-sm text-gray-200"></i>
			<i v-else class="bx bx-x bx-sm text-gray-800"></i>
		</button>
	</div>
</template>
<script setup>
import { onMounted } from "vue";
import useNotifications from "@/composables/useNotifications";

// Composables
const { removeNotification } = useNotifications();

// Define
const props = defineProps({
	notification: Object,
});

// Lifecycle
onMounted(() => {
	setTimeout(() => {
		removeNotification(props.notification.id);
	}, 3000);
});
</script>
