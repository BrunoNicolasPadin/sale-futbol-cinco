<template>
    <div class="relative">
        <select
            class="appearance-none h-full border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
            @change="$emit('change')">
            <option value="" selected>Seleccionar tipo de lugar</option>
            <option v-for="categoria in categorias" :value="categoria.id" :key="categoria.id">{{ categoria.nombre }}</option>
        </select>
    </div>
</template>

<script>
export default {
    props: ['modelValue', 'categorias', 'page'],

    emits: ['update:modelValue', 'change', 'update:page'],

    methods: {
        change() {
            this.$emit('update:page', 1)
        }
    }
}
</script>