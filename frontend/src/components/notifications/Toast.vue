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

		<i
			class="hover:cursor-pointer flex content-center"
			@click="removeNotification(notification.id)">
			<box-icon
				v-if="notification.type != 'warning'"
				name="x"
				color="#E6E6E6"></box-icon>
			<box-icon v-else name="x" color="#333333"></box-icon>
		</i>
	</div>
</template>
<script setup>
import useNotifications from "@/composables/useNotifications";

// Composables
const { removeNotification } = useNotifications();

// Define
const props = defineProps({
	notification: Object,
});
</script>
