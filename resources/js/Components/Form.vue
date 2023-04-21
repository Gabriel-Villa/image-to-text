<template>
    <div class="flex flex-col items-center justify-center">
        <form @submit.prevent="submit" class="w-full mx-auto">
            <div class="card card-compact w-6/12 bg-base-100 shadow-xl mx-auto">
                <div class="card-body">
                    <h1 class="text-2xl font-semibold underline">Preview: </h1>
                    <img :src="preview" />

                    <button type="button" @click="inputFile.click()" class="btn btn-active mt-4">
                        Select File
                    </button>

                    <input type="file" ref="inputFile" class="hidden" @change="handleImageChange">

                    <vue-cropper v-if="imgSrc" ref="cropper" :minContainerWidth=200 :minContainerHeight=200
                        maxContainerHeight=1440 maxContainerWidth=920 dragMode='move' :background=false :movable=false
                        :src="imgSrc" alt="Source Image" @crop="updatePreview" />

                    <div class="card-actions flex justify-between">
                        <button type="submit" class="btn btn-active mt-4">
                            Convert to Text
                        </button>
                        <button @click="clearFile" type="button" class="btn btn-secondary mt-4">
                            Clear Image
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>

<script setup>

    import { router } from '@inertiajs/vue3'
    import { ref } from "vue";
    import VueCropper from "vue-cropperjs";

    const inputFile = ref(null);
    const cropper = ref(null);
    const imgSrc = ref(null);
    const preview = ref(null);

    function handleImageChange(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            imgSrc.value = e.target.result;
            cropper.value.replace(e.target.result);
        };

        reader.readAsDataURL(file);
    }

    function updatePreview() {
        const canvas = cropper.value.getCroppedCanvas();
        preview.value = canvas.toDataURL();
    }

    const clearFile = () => {
        imgSrc.value = null;
        preview.value = null;
    }

    function submit() {
        cropper.value.getCroppedCanvas().toBlob((blob) => {
            router.visit(route('image.store'), {
                method: 'post',
                data: {
                    image: blob
                },
                forceFormData: true,
            })
        });
    }

</script>
