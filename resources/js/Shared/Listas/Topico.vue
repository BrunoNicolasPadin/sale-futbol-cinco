<template>
    <span class="font-bold text-blue-900">{{ punto }}</span>: 
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            punto: String,
        },
    })
</script>