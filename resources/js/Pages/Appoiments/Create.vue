<template>
	<app-layout>
		<template #header>
			<Breadcrumbs :items="breadcrumbs" />
		</template>

		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<form
					class="p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg"
					@submit.prevent="saveAppoiment"
				>
					<!-- <AppImage
						class="mt-2"
						v-model="form.image"
						:image-url="imageUrl"
						label="Image"
						:error-message="form.errors.image"
					/> -->

					<div class="mt-4">
            <jet-label for="category"
                       value="Category" />

            <select name="category"
                    id="category"
                    class="block w-full form-input"
                    v-model="form.category_id">
              <option value="">Select</option>
              <option v-for="category in categories.data"
                      :key="category.id"
                      :value="category.id">{{ category.name }}</option>
            </select>
            <jet-input-error :message="form.errors.category_id"
                             class="mt-2" />
          </div>

					<div class="mt-4">
						<jet-label for="name" value="Title" />
						<jet-input
							id="name"
							type="text"
							class="mt-1 block w-full"
							v-model="form.name"
							autocomplete="name"
						/>
						<jet-input-error :message="form.errors.name" class="mt-2" />
					</div>

					<div class="mt-4">
						<jet-label for="slug" value="Slug" />
						<jet-input
							id="slug"
							type="slug"
							class="mt-1 block w-full"
							v-model="form.slug"
							autocomplete="slug"
						/>
						<jet-input-error :message="form.errors.slug" class="mt-2" />
					</div>

					<div class="mt-4">
						<jet-label for="description" value="Description" />

						<AppCkEditor class="mt-1" v-model="form.description" />

						<jet-input-error :message="form.errors.description" class="mt-2" />
					</div>

					<div class="mt-4">
						<jet-button
							:class="{ 'opacity-25': form.processing }"
							:disabled="form.processing"
						>
							Save
						</jet-button>
					</div>
				</form>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Breadcrumbs from "@/Components/Breadcrumbs";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import AppImage from "@/Components/Image";
import AppCkEditor from "@/Components/CkEditor.vue";
import { strSlug } from "@/helpers.js";
export default {
	components: {
		AppLayout,
		JetInput,
		JetInputError,
		JetLabel,
		Breadcrumbs,
		JetSecondaryButton,
		JetButton,
		AppImage,
		AppCkEditor,
	},
	props: {
		edit: Boolean,
		appoiment: Object,
		categories: {
			type: Object,
			default: function () {
				return {
					data: [],
				};
			},
		},
	},
	data() {
		return {
			imageUrl: "",
			form: this.$inertia.form(
				{
					_method: this.edit ? "PUT" : "",
					category_id: "",
					name: "",
					slug: "",
					description: this.edit ? this.appoiment.data.description : "",
					image: "",
				},
				{
					resetOnSuccess: false,
				}
			),
		};
	},
	computed: {
		breadcrumbs() {
			return [
				{
					label: "Appoiments",
					url: this.route("appoiments.index"),
				},
				{
					label: `${this.edit ? "Edit" : "Add"} Appoiment`,
				},
			];
		},
	},
	methods: {
		saveAppoiment() {
			this.edit
				? this.form.post(
						route("appoiments.update", { id: this.appoiment.data.id })
				  )
				: this.form.post(route("appoiments.store"));
		},
	},
	mounted() {
		if (this.edit) {
			this.form.name = this.appoiment.data.name;
			this.form.slug = this.appoiment.data.slug;
		}
			this.imageUrl = this.appoiment.data.image_url;
	},
};
</script>