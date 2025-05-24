<template>
	<section class="flex flex-col items-center justify-center w-full gap-8">
		<h2 class="text-4xl font-bold text-center text-gray-900">My profile</h2>

		<ChangeDailyReviewsForm></ChangeDailyReviewsForm>

		<hr class="h-0.5 bg-gray-100 w-full" />

		<ChangePasswordForm></ChangePasswordForm>

		<hr class="h-0.5 bg-gray-100 w-full" />

		<DeleteAccountForm></DeleteAccountForm>
	</section>
</template>
<script setup>
import ChangeDailyReviewsForm from "@/components/user/ChangeDailyReviewsForm.vue";
import ChangePasswordForm from "@/components/user/ChangePasswordForm.vue";
import DeleteAccountForm from "@/components/user/DeleteAccountForm.vue";
</script>
