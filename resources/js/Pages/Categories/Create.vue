<template>
	<app-layout>
		<template #header>
			<Breadcrumbs :items="breadcrumbs" />
		</template>
		<Container>
			<Card>
				<form @submit.prevent="saveCategory">
					<!-- Name -->
					<div>
						<jet-label for="name" value="Name" />
						<jet-input
							id="name"
							type="text"
							class="mt-1 block w-full"
							v-model="form.name"
							autocomplete="name"
						/>
						<jet-input-error :message="form.errors.name" class="mt-2" />
					</div>

					<!-- Slug -->
					<div>
						<jet-label for="slug" value="Slug" />
						<jet-input
							id="slug"
							type="text"
							class="mt-1 block w-full"
							v-model="form.slug"
							autocomplete="slug"
						/>
						<jet-input-error :message="form.errors.slug" class="mt-2" />
					</div>
					<div class="mt-4">
						<jet-action-message :on="form.recentlySuccessful" class="mr-3">
							<span v-if="edit">Updated</span>
							<span v-else>Saved</span>
						</jet-action-message>

						<jet-button
							:class="{ 'opacity-25': form.processing }"
							:disabled="form.processing"
						>
							<span v-if="edit">Update</span>
							<span v-else>Save</span>
						</jet-button>
					</div>
				</form>
			</Card>
		</Container>
	</app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import Container from "@/Components/Container";
import Card from "@/Components/Card";
import { strSlug } from "@/helpers.js";
import Breadcrumbs from "@/Components/Breadcrumbs";

export default defineComponent({
	components: {
		AppLayout,
		JetButton,
		JetInput,
		JetInputError,
		JetLabel,
		JetActionMessage,
		Container,
		Card,
		Breadcrumbs,
	},
	props: {
		edit: Boolean,
		category: Object,
	},
	data() {
		return {
			form: this.$inertia.form({
				name: "",
				slug: "",
			}),
		};
	},
	computed: {
		breadcrumbs() {
			return [
				{
					label: "Categories",
					url: route("categories.index"),
				},
				{
					label: `${this.edit ? "Edit" : "Add"} Category`,
				},
			];
		},
	},
	methods: {
		saveCategory() {
			this.edit
				? this.form.put(
						route("categories.update", { id: this.category.data.id })
				  )
				: this.form.post(route("categories.store"));
		},
	},
	watch: {
		"form.name"(name) {
			this.form.slug = strSlug(name);
		},
	},
	mounted() {
		if (this.edit) {
			this.form.name = this.category.data.name;
			this.form.slug = this.category.data.slug;
		}
	},
});
</script>
