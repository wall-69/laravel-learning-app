<template>
	<div
		class="bg-secondary-300 text-secondary-content-300 flex flex-col flex-1 max-w-2xl gap-3 p-4 pb-5 rounded-md">
		<div class="flex gap-1">
			<i class="flex items-center justify-center">
				<box-icon
					name="trending-up"
					type="solid"
					color="#4DEDFF"
					size="sm"></box-icon>
			</i>
			<div class="flex flex-col">
				<h3 class="lg:text-2xl text-xl">Your statistics</h3>
			</div>
		</div>

		<ul>
			<li class="font-bold">
				Streak: <span class="font-normal">12 days</span>
			</li>
			<li class="font-bold">Words: <span class="font-normal">540</span></li>
			<li class="font-bold">
				Words packs: <span class="font-normal">14</span>
			</li>
			<li class="font-bold">Paths: <span class="font-normal">3</span></li>
		</ul>
	</div>
</template>

<script setup></script>
