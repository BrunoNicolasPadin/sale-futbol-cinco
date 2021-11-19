<template>
    <div class="w-full flex-1 svelte-1l8159u">

        <label-componente>
            <template #label-contenido>{{ nombreLabel }}</template>
        </label-componente>

        <div class="bg-white my-2 flex svelte-1l8159u">
            <slot name="inputComponente"></slot>
        </div>

        <info>
            <template #contenido>
                {{ info }}
            </template>
        </info>
    </div>
</template>

<script>

    import LabelComponente from '@/Shared/Formulario/Label'
    import Info from '@/Shared/Formulario/Info'

    export default {
        components: {
            LabelComponente,
            Info,
        },

        props: ['nombreLabel', 'info'],
    }
</script>

