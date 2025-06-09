<template>
	<section class="flex flex-col items-center justify-center w-full gap-8">
		<h2 class="text-4xl font-bold text-center text-gray-900">My profile</h2>

		<ChangeDailyReviewsForm></ChangeDailyReviewsForm>

		<hr class="h-0.5 bg-primary-300 w-1/3" />

		<ChangePasswordForm></ChangePasswordForm>

		<hr class="h-0.5 bg-primary-300 w-1/3" />

		<DeleteAccountForm></DeleteAccountForm>
	</section>
</template>

<script setup>
import ChangeDailyReviewsForm from "@/components/user/ChangeDailyReviewsForm.vue";
import ChangePasswordForm from "@/components/user/ChangePasswordForm.vue";
import DeleteAccountForm from "@/components/user/DeleteAccountForm.vue";
</script>
