<template>
    <input 
        class="w-full border rounded-md pl-10 pr-4 py-2 focus:border-blue-500 focus:outline-none focus:shadow-outline" 
        type="text" 
        placeholder="Buscar partidos"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        @keyup="$emit('escribir')"
        ref="input">
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({

        emits: ['escribir', 'update:modelValue'],

        props: ['modelValue'],
    })
</script>