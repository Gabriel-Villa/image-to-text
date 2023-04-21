<template>
    <div class="flex flex-col justify-center">
        <h1 class="text-2xl font-bold">Result: </h1>

        <textarea v-model="$page.props.output" class="mt-2 textarea textarea-bordered textarea-lg w-5/6 h-3/6 shadow-lg"
            id="textarea-copy"></textarea>
        <button type="button" class="btn flex mt-2 w-20 max-w-sm text-white" @click="copyToClipboard">
            Copy
        </button>
    </div>
</template>

<script setup>

    import { useToast } from 'vue-toast-notification';

    const $toast = useToast();

    function copyToClipboard() {
        const textArea = document.getElementById('textarea-copy')

        textArea.select()

        document.execCommand('copy');

        $toast.success('Copy to clipboard!');
    }

</script>
