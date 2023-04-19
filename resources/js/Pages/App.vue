<template>
    <form @submit.prevent="submit">
        <div class="grid grid-cols-2 h-screen">
            <div class="flex flex-col items-center justify-center">
                <div class="card card-compact w-6/12 bg-base-100 shadow-xl">
                    <figure>
                        <!-- <img class="w-full" ref="image" :src="imageSrc"> -->
                    </figure>
                    <div class="card-body">

                        <img :src="preview" />

                        <button type="button" @click="inputFile.click()" class="btn btn-active mt-4">
                            Select File
                        </button>

                        <input type="file" ref="inputFile" class="hidden" @change="handleImageChange">

                        <vue-cropper
                            v-if="imgSrc"
                            ref="cropper"
                            :minContainerWidth=200
                            :minContainerHeight=200
                            dragMode='move'
                            :background=false
                            :movable=false
                            :src="imgSrc"
                            alt="Source Image"
                            @crop="updatePreview"
                        />

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
            </div>
            <div class="flex flex-col justify-center">
                <h1 class="text-2xl font-bold">Result: </h1>

                <textarea class="mt-2 textarea textarea-bordered textarea-lg w-5/6 h-3/6 shadow-lg"></textarea>
                <button class="btn flex mt-2 w-20 max-w-sm text-white">
                    Copy
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
    import { ref } from "vue";
    import axios  from "axios";
    import { useForm } from '@inertiajs/vue3'
    import VueCropper from "vue-cropperjs";

    const inputFile = ref(null);

    const cropper = ref(null);
    const imgSrc = ref(null);
    const preview = ref(null);

    const form = useForm({
        image: null,
    })

    function handleImageChange(event)
    {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            imgSrc.value = e.target.result;
            cropper.value.replace(e.target.result);
        };

        reader.readAsDataURL(file);
    }

    function updatePreview()
    {
        const canvas = cropper.value.getCroppedCanvas();
        preview.value = canvas.toDataURL();
    }

    const clearFile = () =>
    {
        imgSrc.value = null;
        preview.value = null;
    }

    function submit()
    {
        cropper.value.getCroppedCanvas().toBlob((blob) =>
        {

            var data = new FormData();
            data.append('cropped_picture', blob, 'cropped.png')

            axios.post('/send', data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                console.log(response);
            }).catch(error => {
                console.log(error);
            });

        });

    }

</script>
