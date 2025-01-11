<template>
	<main class="flex flex-col flex-1">
		<CustomHeader></CustomHeader>

		<!-- 
			Section: Hero
		-->

		<section
			class="bg-hero h-screen-wo-nav flex flex-col items-center justify-center bg-center bg-cover">
			<h2 class="text-primary-300 text-7xl leading-normal">DailyVocab</h2>
			<p
				class="max-w-[800px] max-h-[200px] text-3xl text-center text-white break-words">
				effective vocabulary learning, focused on
				<span class="font-medium">daily habit</span>,
				<span class="font-medium">long&#x2011;term</span> memory storage,
				<span class="font-medium">retrieval practice</span> and
				<span class="font-medium">spaced repetition</span>.
			</p>
			<RouterLink
				:to="{ name: 'register' }"
				class="btn-register-secondary mt-8">
				REGISTER
			</RouterLink>
		</section>

		<!-- 
			Section: Main Concepts
		-->

		<section class="px-6 py-32">
			<h2 class="pb-16 text-4xl font-bold text-center text-gray-700">
				MAIN CONCEPTS
			</h2>

			<ul class="gap-x-6 gap-y-8 justify-evenly flex flex-wrap items-start">
				<!-- Grouping -->
				<li>
					<h3 class="text-3xl font-bold">Grouping</h3>
					<div class="flex items-center gap-4">
						<i
							class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
							<box-icon
								name="cabinet"
								type="solid"
								color="#ffffff"
								size="lg"></box-icon>
						</i>
						<p class="max-w-sm">
							Five-word groups, ranging from reviewing a word daily to reviewing
							it twice a month.
						</p>
					</div>
				</li>
				<!-- Daily Review -->
				<li>
					<h3 class="text-3xl font-bold">Daily Review</h3>
					<div class="flex items-center gap-4">
						<i
							class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
							<box-icon
								name="calendar-check"
								type="solid"
								color="#ffffff"
								size="lg"></box-icon>
						</i>
						<p class="max-w-sm">
							Create a habit of daily review with a selectable daily limit of
							words.
						</p>
					</div>
				</li>
				<!-- Instant Feedback -->
				<li>
					<h3 class="text-3xl font-bold">Instant Feedback</h3>
					<div class="flex items-center gap-4">
						<i
							class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
							<box-icon
								name="message-error"
								type="solid"
								color="#ffffff"
								size="lg"></box-icon>
						</i>
						<p class="max-w-sm">
							If you forget a word, there is a chance that you will remember
							this word better after being corrected.
						</p>
					</div>
				</li>
				<!-- Provided Context -->
				<li>
					<h3 class="text-3xl font-bold">Provided Context</h3>
					<div class="flex items-center gap-4">
						<i
							class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
							<box-icon
								name="info-circle"
								type="solid"
								color="#ffffff"
								size="lg"></box-icon>
						</i>
						<p class="max-w-sm">
							Words include their context, example usage in a sentence, and may
							also have a visual image representing the word.
						</p>
					</div>
				</li>
				<!-- Long-term Memory Storage -->
				<li>
					<h3 class="text-3xl font-bold">Long-term Memory Storage</h3>
					<div class="flex items-center gap-4">
						<i
							class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
							<box-icon
								name="brain"
								type="solid"
								color="#ffffff"
								size="lg"></box-icon>
						</i>
						<p class="max-w-sm">
							Retrieval practice and spaced repetition increases the chance of
							storing vocabulary in long-term memory instead of short-term
							memory.
						</p>
					</div>
				</li>
			</ul>
		</section>

		<!-- 
			Section: How does this work?
		 -->

		<section class="bg-primary-100 flex items-center justify-between p-32">
			<div class="flex flex-col max-w-lg">
				<h2 class="text-secondary-100 text-4xl font-bold">
					How does this work?
				</h2>

				<p class="mb-4">
					Our app is based on a modified learning system of (virtual)
					flashcards, created by German science journalist Sebastian Leitner,
					called the Leitner System.
				</p>
				<p class="mb-2">
					Spaced repetition and retrieval practice increases the chance of
					retention in the long&#x2011;term memory, based on research<!-- 
					--><span class="text-secondary-100">*</span>. In contrast, cramming often causes
					students to store information in short-term memory.
				</p>

				<span class="text-secondary-100 text-sm">
					*
					<a href="#" class="hover:text-secondary-200 underline">
						www.researchlink.com
					</a>
				</span>
			</div>

			<img
				src="@/assets/img/forgetting-curve.png"
				alt="Graph shows how repeated reviewing increases memory retention."
				class="max-h-96 border-primary-500 border-4" />
		</section>

		<!-- 
			Section: Five-group system
		 -->

		<section class="flex items-center justify-between p-32">
			<img
				src="@/assets/img/leitner-boxes.png"
				alt="5 boxes where correctly answered card is moved to next box. Incorrectly answered card is moved to box 1."
				class="border-primary-500 max-w-xl border-4" />

			<div class="flex flex-col max-w-lg">
				<h2 class="text-secondary-100 text-4xl font-bold">
					How does this work?
				</h2>

				<p class="mb-4">
					Our app is based on a modified learning system of (virtual)
					flashcards, created by German science journalist Sebastian Leitner,
					called the Leitner System.
				</p>
				<p class="mb-2">
					Spaced repetition and retrieval practice increases the chance of
					retention in the long&#x2011;term memory, based on research<!-- 
					--><span class="text-secondary-100">*</span>. In contrast, cramming often causes
					students to store information in short-term memory.
				</p>

				<span class="text-secondary-100 text-sm">
					*
					<a href="#" class="hover:text-secondary-200 underline">
						www.researchlink.com
					</a>
				</span>
			</div>
		</section>

		<!-- 
			Section: Features and CTA
		-->

		<section class="bg-primary-100 flex items-center justify-between p-32">
			<ul class="flex flex-col gap-12">
				<!-- Build a Habit -->
				<li class="flex max-w-lg gap-4">
					<i
						class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
						<box-icon
							name="calendar"
							type="solid"
							color="#ffffff"
							size="lg"></box-icon>
					</i>
					<div class="flex flex-col">
						<h2 class="text-3xl font-bold">Build a Habit</h2>
						<p class="mb-4">
							Check in daily for your daily words. Building a habit is no easy
							task, but we hope our habit tracker can help. Remember, missing
							once is an accident; missing twice is the start of a new habit.
						</p>
						<p>If no words are due for review, you get a free day!</p>
					</div>
				</li>
				<!-- Custom Word Packs -->
				<li class="flex max-w-lg gap-4">
					<i
						class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
						<box-icon
							name="customize"
							type="solid"
							color="#ffffff"
							size="lg"></box-icon>
					</i>
					<div class="flex flex-col">
						<h2 class="text-3xl font-bold">Custom Word Packs</h2>
						<p>
							Are you a teacher? Maybe an enthusiastic vocabulary learner?
							Doesnt matter! Create your own Word Packs and choose who can use
							them!
						</p>
						<ul class="flex flex-col">
							<!-- Public -->
							<li class="flex gap-2">
								<i>
									<box-icon
										name="school"
										type="solid"
										color="#082191"
										size="lg"></box-icon>
								</i>
								<p>
									<span class="font-bold">Public</span> visibility - share your
									Word Packs in our community.
								</p>
							</li>
							<!-- Private -->
							<li class="flex gap-2">
								<i>
									<box-icon
										name="user-circle"
										type="solid"
										color="#082191"
										size="lg"></box-icon>
								</i>
								<p>
									<span class="font-bold">Private</span> visibility - for your
									personal use. Share them with your friends, family or
									students.
								</p>
							</li>
						</ul>
					</div>
				</li>
				<!-- Choose your vocabulary -->
				<li class="flex max-w-lg gap-4">
					<i
						class="bg-secondary-300 max-w-min h-min flex content-center p-4 rounded-full">
						<box-icon
							name="user-voice"
							type="solid"
							color="#ffffff"
							size="lg"></box-icon>
					</i>
					<div class="flex flex-col">
						<h2 class="text-3xl font-bold">Build a Habit</h2>
						<p>
							Select the field of vocabulary you want learn. Choose a Path to
							gradually unlock Word Packs, or add Word Packs on their own to
							your vocabulary.
						</p>
					</div>
				</li>
			</ul>

			<form action="">form maybe</form>
		</section>
	</main>

	<CustomFooter></CustomFooter>
</template>

<script setup>
import CustomHeader from "@/components/Header.vue";
import CustomFooter from "@/components/Footer.vue";
import { RouterLink } from "vue-router";
</script>
