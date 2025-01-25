<template>
	<div class="bg-secondary-300 flex flex-col items-center gap-2 p-4 rounded-md">
		<div class="flex flex-col items-center">
			<h2 class="text-primary-300 text-xl">Daily Review</h2>
			<p class="text-gray-100">Continue your daily streak!</p>
		</div>

		<VCalendar :attributes="calendarAttributes" trim-weeks>
			<template #footer>
				<div class="flex items-center justify-center w-full pb-3">
					<button
						class="bg-secondary-100 hover:bg-primary-400 px-4 py-2 text-white rounded-md">
						Review
					</button>
				</div>
			</template>
		</VCalendar>
	</div>
</template>
<script setup>
import { ref } from "vue";
import { eachDayOfInterval } from "date-fns";

// Highlight solid (reviewable), light (pass day) => today
// Highlight solid => reviewed day
// Highlight light => pass day
// Dot red/blue => missed day

// TODO: custom popover which will handle all messages and if it is todays date, then handle clicking on it
//       maybe get rid of Review button?

const userRegistrationDate = new Date();
userRegistrationDate.setDate(userRegistrationDate.getDate() - 10);
const yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);
const calendarAttributes = ref([
	// Today
	{
		key: "today",
		highlight: true, // TODO: check, if today was already reviewed or not
		dates: new Date(),
		popover: {
			label: "Click to review.",
			hideIndicator: true,
		},
	},
	// Reviewed days
	{
		key: "reviewedDays",
		highlight: true,
		dates: eachDayOfInterval({
			start: new Date("2025-1-11"),
			end: new Date("2025-1-13"),
		}),
		popover: {
			label: "Reviewed!",
			hideIndicator: true,
		},
	},
	// Free days
	{
		key: "freeDay",
		highlight: {
			color: "blue",
			fillMode: "light",
		},
		dates: [new Date("2025-1-23"), new Date("2025-1-14")], // TODO: filter free days & missed days
		popover: {
			label: "Free day.",
			hideIndicator: true,
		},
	},
	// Missed days
	{
		key: "missedDays",
		dot: true,
		dates: eachDayOfInterval({
			start: userRegistrationDate, // All days since users registration
			end: yesterdayDate, // All days until yesterday
		}),
		popover: {
			label: "Missed day.",
			hideIndicator: true,
		},
	},
]);
</script>
