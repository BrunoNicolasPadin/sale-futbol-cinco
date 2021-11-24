<template>
    <h1 class="text-xl">
        <span class="font-normal">{{ titulo }}</span>: {{ valor }}
    </h1>

    <hr class="bg-gray-300 p-px my-2">
</template>

<script>
    import { defineComponent } from 'vue'
    export default defineComponent ({
        props: ['titulo', 'valor'],
    })
</script>