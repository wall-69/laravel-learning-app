<template>
	<div
		v-if="data && Object.keys(data).length > 0"
		class="bg-secondary-400 flex-1 max-w-full overflow-x-auto">
		<table>
			<thead>
				<tr>
					<th
						v-for="(field, i) in Object.keys(data[0])"
						:key="i"
						class="px-4 pt-4 text-lg text-gray-100">
						{{ field }}
					</th>
					<th class="px-4 pt-4 text-lg text-gray-100">Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(d, i) in data">
					<td
						v-for="dData in d"
						:key="i"
						class="px-4 py-2 text-center text-gray-100 align-middle">
						{{ dData }}
					</td>
					<!-- Actions -->
					<td class="px-4 py-2 text-center align-middle">
						<!-- Edit -->
						<button @click="console.log('edit')" class="mr-2">
							<i>
								<box-icon name="edit" type="solid" color="#F1F1F1"></box-icon>
							</i>
						</button>
						<!-- Delete -->
						<button @click="handleDeletion(d.id)">
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
import { handleRequest } from "@/utils/requestWrapper";
import axios from "axios";

// Define
const props = defineProps({
	data: Array,
	modelName: String,
});
const emit = defineEmits(["data-deleted"]);

// Functions
async function handleDeletion(id) {
	confirm(
		"Are you sure you want to delete this " +
			props.modelName.charAt(0).toUpperCase() +
			props.modelName.slice(1).replace("-", " ") +
			"?"
	);

	await handleRequest({
		request: (data) => {
			return axios.post("/api/" + props.modelName + "s" + "/" + id);
		},
		succesCallback: (response) => {},
	});

	emit("data-deleted");
}
</script>
