<template>
	<div class="bg-secondary-300 flex flex-col items-center gap-2 p-4 rounded-md">
		<div class="flex flex-col items-center">
			<h2 class="text-primary-300 text-xl">Daily Review</h2>
			<p class="text-gray-100">Continue your daily streak!</p>
		</div>

		<VCalendar :attributes="calendarAttributes" trim-weeks>
			<template #footer>
				<div class="flex items-center justify-center w-full pb-3">
					<button @click="review" class="btn-secondary">Review</button>
				</div>
			</template>
		</VCalendar>
	</div>
</template>
<script setup>
// NOTICE:
// The most important thing is to know if fucking timezones are taken care of.
// If not, you will be stuck on a bug for an hour because of a fucking timezone mismatch.
// I <3 timezones.
import { ref } from "vue";
import router from "@/router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";

// Stores
const { user } = storeToRefs(useAuthStore());

// Variables
const userRegistrationDate = getUserRegistrationUTCDate();

const yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);

const reviewedDays = user.value.user_reviews.map(({ date }) =>
	toUTCDateOnly(date)
);

const calendarAttributes = ref([
	// Today
	{
		key: "today",
		highlight: {
			color: "blue",
			fillMode: "light",
		},
		dates: user.value.hasDueWords ? new Date() : null,
		popover: {
			label: "Your daily review awaits!",
		},
	},
	// Reviewed days
	{
		key: "reviewedDays",
		highlight: true,
		dates: reviewedDays,
		popover: {
			label: "Reviewed!",
		},
	},
	// Registration date
	{
		key: "registration",
		dot: {
			color: "red",
			fillMode: "light",
		},
		dates: userRegistrationDate,
		popover: {
			label: "The day you registered.",
		},
	},
]);

// Functions
async function review() {
	await router.replace({ name: "review" });
}

function toUTCDateOnly(date) {
	const d = new Date(date);
	return new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
}

function getUserRegistrationUTCDate() {
	// d.m.Y H:i
	const [date, time] = user.value.created_at.split(" ");

	const [day, month, year] = date.split(".");
	const [hours, minutes] = time.split(":");

	return new Date(Date.UTC(year, month - 1, day, hours, minutes));
}
</script>
