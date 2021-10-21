<template>
	<ckeditor :editor="editor" v-model="text" :config="editorConfig"></ckeditor>
</template>

<script>
import ClasicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
	props: {
		value: {},
	},
	data() {
		return {
			text: "",
			editor: ClasicEditor,
			editorConfig: {
				// The configuration of the editor.
			},
		};
	},

	watch: {
        value:{
            inmediate: true,
            handler(value){
                this.text = value;
            }
        },
		text(text) {
			this.$emit("input", text);
		},
	},
};
</script>