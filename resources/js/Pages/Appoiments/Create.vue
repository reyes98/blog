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
					<!-- Name -->
					<div class="mt-4">
						<jet-label for="name" value="Name" />
						<jet-input
							id="name"
							type="text"
							class="mt-1 block w-full"
							v-model="form.name"
							autocomplete="name"
							:readonly="edit"
						/>
						<jet-input-error :message="form.errors.name" class="mt-2" />
					</div>

					<!-- Email -->
					<div class="mt-4">
						<jet-label for="email" value="Email" />
						<jet-input
							id="email"
							type="email"
							class="mt-1 block w-full"
							v-model="form.email"
							autocomplete="email"
							:readonly="edit"
						/>
						<jet-input-error :message="form.errors.email" class="mt-2" />
					</div>

					<!-- Phone -->
					<div class="mt-4">
						<jet-label for="phone" value="Phone" />
						<jet-input
							id="phone"
							type="text"
							class="mt-1 block w-full"
							v-model="form.phone"
							autocomplete="phone"
							:readonly="edit"
						/>
						<jet-input-error :message="form.errors.phone" class="mt-2" />
					</div>

					<!-- Start_time -->
					<div class="mt-4">
						<jet-label for="start_time" value="Appoiment Date" />
						<jet-input
							id="start_time"
							type="datetime-local"
							class="mt-1 block w-full"
							v-model="form.start_time"
							autocomplete="start_time"
							:min="new Date().toISOString().slice(0, 16)"
						/>
						<jet-input-error :message="form.errors.start_time" class="mt-2" />
					</div>
					

					<!-- Status -->
					<div class="mt-4">
						<jet-label for="appoiment" value="Appoiment" />

						<select
							name="status"
							id="status"
							class="block w-full form-input"
							v-model="form.status"
						>
							<option
								v-for="(option, index) in statusOptions"
								:key="index"
								:value="index"
							>
								{{ option }}
							</option>
						</select>
						<jet-input-error :message="form.errors.status" class="mt-2" />
					</div>

					<!-- Price -->
					<div class="mt-4">
						<jet-label for="price" value="Price" />
						<jet-input
							id="price"
							type="number"
							class="mt-1 block w-full"
							v-model="form.price"
							autocomplete="price"							
						/>
						<jet-input-error :message="form.errors.price" class="mt-2" />
					</div>

					<!-- Message -->
					<div class="mt-4">
						<jet-label for="message" value="Message" />
						<AppTextarea
							id="message"
							type="text"
							class="mt-1 block w-full form-input"
							v-model="form.message"
							autocomplete="message"
							:readonly="edit"
						/>
						<jet-input-error :message="form.errors.message" class="mt-2" />
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
import AppTextarea from "@/Components/Textarea";
export default {
	components: {
		AppLayout,
		JetInput,
		JetInputError,
		JetLabel,
		Breadcrumbs,
		JetSecondaryButton,
		JetButton,
		AppTextarea,
	},
	props: {
		edit: Boolean,
		appoiment: Object,
		statusOptions: {},
	},
	data() {
		return {
			form: this.$inertia.form(
				{
					_method: this.edit ? "PUT" : "",
					name: "",
					email: "",
					status: "",
					start_time: "",
					phone: "",
					price: "",
					message: this.edit ? this.appoiment.data.message : "",
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
			this.form.email = this.appoiment.data.email;
			this.form.status = this.appoiment.data.status;
			this.form.phone = this.appoiment.data.phone;
			this.form.price = this.appoiment.data.price;
			this.form.start_time = this.appoiment.data.start_time;
		}
	},
};
</script>