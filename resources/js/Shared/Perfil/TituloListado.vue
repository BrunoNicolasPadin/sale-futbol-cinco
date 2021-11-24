<template>
    <h1 class="text-3xl my-3 font-normal">
        {{ titulo }}
    </h1>
</template>

<script>
    import { defineComponent } from 'vue'
    export default defineComponent ({
        props: ['titulo'],
    })
</script>