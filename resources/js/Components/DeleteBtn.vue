<template>
	<div class="flex items-center">
		<button @click.prevent="show = true">
			<svg
				xmlns="http://www.w3.org/2000/svg"
				class="h-6 w-6 text-red-500"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor"
			>
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
				/>
			</svg>
		</button>

		<confirmation-modal :show="show">
			<template #title> Delete {{ moduleName }} </template>
			<template #content>
				Are you sure you want to delete this {{ moduleName }}
			</template>
			<template #footer>
				<secondary-button @click="show = false">
					Nevermind
				</secondary-button>
				<danger-button
					class="ml-2"
					@click="deleteItem"
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
				>
					Delete
				</danger-button>
			</template>
		</confirmation-modal>
	</div>
</template>

<script>
import ConfirmationModal from "@/Jetstream/ConfirmationModal";
import SecondaryButton from "@/Jetstream/SecondaryButton";
import DangerButton from "@/Jetstream/DangerButton";
export default {
	components: {
		ConfirmationModal,
		SecondaryButton,
		DangerButton,
	},
	props: {
		url: {
			require: true,
			type: String,
		},
		moduleName: {
			require: true,
			type: String,
		},
	},
	data() {
		return {
			show: false,
			form: this.$inertia.form({}),
		};
	},
	methods: {
		deleteItem() {
			this.show = false;
			this.form.delete(this.url);
		},
	},
};
</script>