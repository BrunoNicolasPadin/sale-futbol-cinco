<template>
    <Link :href="route(ruta, idsArray)" class="hover:underline">{{ bread }}</Link> / 
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    
    export default defineComponent({
        components: {
            Link,
        },

        props: {
            ruta: String,
            idsArray: Array,
            bread: String,
        },
    })
</script>