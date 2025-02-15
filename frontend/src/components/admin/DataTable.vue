<template>
	<div
		v-if="data && Object.keys(data).length > 0"
		class="bg-secondary-400 flex-1 max-w-full overflow-x-auto">
		<table class="w-full border-separate">
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
						{{ dData }}
					</td>
					<!-- Actions -->
					<td
						v-if="edittable || deletable"
						class="bg-secondary-400 border-secondary-200 sticky right-0 px-4 py-2 text-center align-middle border-l-2">
						<!-- Edit -->
						<button @click="handleEdit(d.id)" class="mr-2" v-if="edittable">
							<i>
								<box-icon name="edit" type="solid" color="#F1F1F1"></box-icon>
							</i>
						</button>
						<!-- Delete -->
						<button @click="handleDelete(d.id)" v-if="deletable">
							<i>
								<box-icon name="trash" type="solid" color="#F1F1F1"></box-icon>
							</i>
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>
<script setup>
import router from "@/router";
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";
import { onMounted } from "vue";

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
});

const emit = defineEmits(["update:data"]);

// Lifecycle hooks
onMounted(async () => {
	await loadData();
});

// Functions
async function loadData() {
	await handleRequest({
		request: () => axios.get("/api/" + props.modelName + "s"),
		successCallback: async (response) => {
			emit("update:data", response.data);
		},
		failCallback: async (response) => {
			console.error("Could not load users from the database.", response);
		},
	});
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
</script>
