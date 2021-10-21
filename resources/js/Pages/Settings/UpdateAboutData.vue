<template>
	<jet-form-section @submitted="updateAboutInformation">
		<template #title> About Me Information </template>

		<template #description> Update the about me section data.</template>

		<template #form>
			<!--  Photo -->
			<div
				class="col-span-6 sm:col-span-6"
				v-if="$page.props.jetstream.managesProfilePhotos"
			>
				<AppImage
					:image-url="settings.data.about_image_url"
					label="Photo"
					:errormessage="form.errors.about_image"
					v-model="form.about_image"
				/>
			</div>

			<!-- Description -->
			<div class="col-span-6 sm:col-span-6">
				<jet-label for="description" value="Description" />
				<AppCkEditor v-model="form.about_description" />

				<jet-input-error
					:message="form.errors.about_description"
					class="mt-2"
				/>
			</div>
		</template>

		<template #actions>
			<jet-action-message :on="form.recentlySuccessful" class="mr-3">
				Saved.
			</jet-action-message>

			<jet-button
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing"
			>
				Save
			</jet-button>
		</template>
	</jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import AppImage from "@/Components/Image.vue";
import AppCkEditor from "@/Components/CkEditor.vue";

export default {
	components: {
		JetActionMessage,
		JetButton,
		JetFormSection,
		JetInput,
		JetInputError,
		JetLabel,
		JetSecondaryButton,
		AppImage,
		AppCkEditor,
	},

	props: ["settings"],

	data() {
		return {
			form: this.$inertia.form(
				{
					about_description: this.settings.data.about_description,
					about_image: null,
				},
				{
					resetOnSuccess: false,
				}
			),
		};
	},

	methods: {
		updateAboutInformation() {
			this.form.post(route("settings.save-about"), {
				preserveScroll: true,
			});
		},
	},
};
</script>
