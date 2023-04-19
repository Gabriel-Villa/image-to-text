<template>
    <div>
      <input type="file" @change="handleImageChange" />

      <div class="w-64 bg-red-500">
        Hola
      </div>
      <vue-cropper
        ref="cropper"
        :minContainerWidth=200
        :minContainerHeight=200
        dragMode='move'

        :background=false
        :src="imgSrc"
        alt="Source Image" />
    </div>
  </template>

<script setup>
  import VueCropper from "vue-cropperjs";
  import "cropperjs/dist/cropper.css";
  import { ref } from "vue";

  const cropper = ref(null);
  const imgSrc = ref(
    "https://a0.muscache.com/im/pictures/af7c7616-0c3e-40ca-9f7e-4bf1939c74f5.jpg?im_w=720"
  );

  function handleImageChange(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = (e) => {
      imgSrc.value = e.target.result;
      cropper.value.replace(e.target.result);
    };

    reader.readAsDataURL(file);
  }
</script>
<!-- minWidth="1400" -->
<!-- minHeight="920" -->
<!-- :cropBoxResizable=false -->
