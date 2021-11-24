<template>
    <div class="my-2 bg-white p-2 rounded-lg shadow-lg">
        <h1 class="text-xl my-2">
            <span class="font-bold text-gray-700">
                <slot name="titulo-cabecera"></slot>
            </span>: 
            <slot name="calificacion-cabecera"></slot>
        </h1>

        <hr v-if="comentario" class="bg-gray-200 p-px">

        <div v-if="comentario">
            <h1 class="text-xl my-2 font-bold text-gray-700">Comentario:</h1>
            <p class="whitespace-pre-line">{{ comentario }}</p>
        </div>

        <hr v-if="user_id == objeto.user_id " class="bg-gray-200 p-px my-3">

        <div v-if="user_id == objeto.user_id ">
            <div class="flex justify-end">
                <slot name="botones"></slot>
            </div>
        </div>
    </div>

    <hr class="bg-gray-300 p-px my-3">
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            comentario: Object,
            objeto: Object,
            user_id: String,
        }
    })
</script>