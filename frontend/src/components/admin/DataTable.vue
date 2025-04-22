<template>
	<div
		v-if="data && Object.keys(data).length > 0"
		class="bg-secondary-400 flex flex-col justify-between flex-1 max-w-full overflow-x-auto">
		<table v-show="!loading" class="w-full border-separate">
			<thead>
				<tr>
					<th
						v-for="(field, i) in Object.keys(data[0])"
						:key="i"
						class="px-4 pt-4 text-lg text-center text-gray-100">
						{{ field }}
					</th>
					<th
						v-if="edittable || deletable"
						class="bg-secondary-400 border-secondary-200 sticky right-0 px-4 pt-4 text-lg text-gray-100 border-l-2">
						Actions
					</th>
				</tr>
			</thead>
			<tbody class="relative">
				<tr v-for="(d, i) in data">
					<td
						v-for="dData in d"
						:key="i"
						class="px-4 py-2 text-center text-gray-100 align-middle">
						<template
							v-if="
								dData && typeof dData == 'string' && dData.startsWith('storage')
							">
							<img :src="asset(dData)" alt="" class="max-w-12 mx-auto" />
						</template>
						<template v-else>
							{{ dData }}
						</template>
					</td>
					<!-- Actions -->
					<td
						v-if="edittable || deletable"
						class="bg-secondary-400 border-secondary-200 sticky right-0 px-4 py-2 text-center align-middle border-l-2">
						<!-- Edit -->
						<button @click="handleEdit(d.id)" class="mr-2" v-if="edittable">
							<i class="bx bxs-edit bx-sm text-gray-100"></i>
						</button>
						<!-- Delete -->
						<button @click="handleDelete(d.id)" v-if="deletable">
							<i class="bx bxs-trash bx-sm text-gray-100"></i>
						</button>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="flex items-center justify-center w-full gap-2">
			<button @click="previousPage" :disabled="page <= 1 || loading">
				<i
					class="bx bxs-chevron-left bx-md text-gray-100"
					:class="{
						'opacity-50': page <= 1,
					}">
				</i>
			</button>

			<span class="mb-1 text-xl font-bold text-gray-100">
				{{ page }}
			</span>

			<button @click="nextPage" :disabled="page >= maxPage || loading">
				<i
					class="bx bxs-chevron-right bx-md text-gray-100"
					:class="{
						'opacity-50': page >= maxPage,
					}">
				</i>
			</button>
		</div>
	</div>
	<div v-else v-show="!loading"><p>No data was added yet.</p></div>
</template>
<script setup>
import router from "@/router";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { asset } from "@/utils/asset";
import { useRoute } from "vue-router";

// Composables
const route = useRoute();

// Define
const props = defineProps({
	data: Array,
	modelName: String,
	edittable: {
		default: true,
		type: Boolean,
	},
	deletable: {
		default: true,
		type: Boolean,
	},
	search: {
		default: null,
		type: String,
		required: false,
	},
});

const emit = defineEmits(["update:data"]);

// Lifecycle hooks
onMounted(async () => {
	await loadData();
});

// Variables
const page = ref(1);
const maxPage = ref(1);
const loading = ref(false);

// Functions
async function loadData() {
	loading.value = true;

	let requestUrl = "/api/" + props.modelName + "s";
	requestUrl += "?page=" + page.value;
	if (props.search) {
		requestUrl += "&search=" + props.search;
	}

	await handleRequest({
		request: () => axios.get(requestUrl),
		successCallback: async (response) => {
			page.value = response.data.current_page;
			maxPage.value = response.data.last_page;

			// response.data is Laravel pagination object, inside it is data field with the data
			emit("update:data", response.data.data);
		},
		failCallback: async (response) => {
			console.error(
				"Could not load " + props.modelName + "s from the database.",
				response
			);
		},
	});

	loading.value = false;
}

function handleEdit(id) {
	router.replace({
		name: "admin-" + props.modelName + "s" + "-edit",
		params: { id: id },
	});
}

async function handleDelete(id) {
	const modelNameFormatted =
		props.modelName.charAt(0).toUpperCase() +
		props.modelName.slice(1).replace("-", " ");
	confirm("Are you sure you want to delete this " + modelNameFormatted + "?");

	await handleRequest({
		request: (data) => {
			return axios.delete("/api/" + props.modelName + "s" + "/" + id);
		},
		successCallback: async (response) => {
			loadData();
		},
	});
}

async function previousPage() {
	if (page.value > 1) {
		page.value -= 1;

		await loadData();
	}
}

async function nextPage() {
	if (page.value != maxPage) {
		page.value += 1;

		await loadData();
	}
}

// Watcher
watch(
	() => props.search,
	(newSearch, oldSearch) => {
		page.value = 1;

		loadData();
	}
);
</script>
