<template>
    <!-- <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 my-4 p-2 rounded-md bg-indigo-50 border-2 border-indigo-100 shadow-md">
        <div>
            <slot name="imagen"></slot>
        </div>

        <div class="ml-2 col-span-2 md:col-span-4 lg:col-span-6 grid grid-col-1">
            <h2 class="text-lg font-semibold text-black mb-0.5">
                <slot name="nombre"></slot>
            </h2>

            <span class="mt-3 text-sm font-medium whitespace-pre-wrap">
                <slot name="informacion"></slot>
            </span>

            <span class="mt-3 text-sm font-medium">
                <slot name="horarios"></slot>
            </span>
        </div>
    </div> -->

    <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-x-2 bg-white p-4 rounded-md shadow-md border-2 border-green-500 my-4">
        <div v-if="urlFoto" class="flex justify-center">
            <img :src='urlFoto' 
            alt="Foto de perfil o escudo"
            class="w-2/3">
        </div>

        <div class="col-span-2 md:col-span-4 lg:col-span-6">
            <h1 class="text-2xl font-semibold">
                {{ nombre }}
            </h1>
            <!-- <div class="grid grid-cols-2">
                <slot name="contenido-debajo-del-nombre"></slot>
            </div> -->
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            urlFoto: String,
            nombre: String,
        },
    }
</script>