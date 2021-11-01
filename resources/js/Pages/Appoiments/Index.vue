<template>
	<app-layout title="Dashboard">
		<template #header>
			<Breadcrumbs :items="breadcrumbs" />
		</template>

		<Container>
			<jet-button :href="route('appoiments.create')">Add new</jet-button>
			<Card class="mt-4">
				<div class="flex">
					<div class="mb-4 max-w-xs mx-4">
						<input
							type="search"
							v-model="params.search"
							aria-label="Search"
							placeholder="Search..."
							class="
								block
								w-full
								rounded-md
								border-gray-300
								shadow-sm
								focus:ring-indigo-500 focus:border-indigo-500
								sm:text-sm
							"
						/>
					</div>
					<div class="mb-4 max-w-xs mx-4">
						<select
							v-model="params.status"
							class="
								block
								w-full
								rounded-md
								shadow-sm
								focus:ring-indigo-500 focus:border-indigo-500
								sm:text-sm
							"
						>
							<option
								v-for="(option, index) in selectOptions"
								:key="index"
								:value="option"
							>
								{{ option }}
							</option>
						</select>
					</div>
				</div>

				<AppTable :headers="headers" :items="appoiments">
					<tr v-for="appoiment in appoiments.data" :key="appoiment.id">
						<td>{{ appoiment.name }}</td>
						<td>{{ appoiment.email }}</td>
						<td>{{ appoiment.status }}</td>
						<td>{{ appoiment.start_time }}</td>
						<td>
							<div class="flex items-center justify-end space-x-2">
								<EditBtn
									:url="route('appoiments.edit', { appoiment: appoiment.id })"
								/>
								<DeleteBtn
									:url="
										route('appoiments.destroy', { appoiment: appoiment.id })
									"
									module-name="appoiment"
								/>
							</div>
						</td>
					</tr>
				</AppTable>
			</Card>
		</Container>
	</app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import EditBtn from "@/Components/EditBtn.vue";
import DeleteBtn from "@/Components/DeleteBtn.vue";
import AppTable from "@/Components/Table";
import Container from "@/Components/Container";
import Card from "@/Components/Card";
import JetButton from "@/Jetstream/Button";
import Breadcrumbs from "@/Components/Breadcrumbs";

export default defineComponent({
	components: {
		AppLayout,
		EditBtn,
		DeleteBtn,
		AppTable,
		Container,
		Card,
		JetButton,
		Breadcrumbs,
	},
	props: {
		appoiments: {},
		selectOptions: {},
		filters: {},
	},
	data() {
		return {
			params: {
				search: this.filters.search,
				status: this.filters.status
					? this.filters.status
					: this.selectOptions[1],
			},
		};
	},
	watch: {
		params: {
			handler() {
				this.$inertia.get(this.route("appoiments.index"), this.params, {
					replace: true,
					preserveState: true,
					preserveScroll: true,
				});
			},
			deep: true,
		},
	},
	computed: {
		headers() {
			return [
				{
					name: "Name",
				},
				{
					name: "Email",
				},
				{
					name: "Status",
				},
				{
					name: "Date",
				},
				{
					name: "Action",
					class: "text-right",
				},
			];
		},
		breadcrumbs() {
			return [
				{
					label: "Appoiments",
				},
			];
		},
	},
});
</script>
