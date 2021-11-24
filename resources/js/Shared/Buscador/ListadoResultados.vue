<template>
    <div class="my-3 bg-white shadow-md rounded-md p-4">
        <div class="text-base font-semibold text-green-800">
            <slot name="cabecera"></slot>
        </div>
        
        <h1 class="text-2xl font-black mt-3">
            <slot name="nombre"></slot>
        </h1>

        <div class="text-base">
            <div class="flex flex-wrap space-x-2">
                <slot name="opciones"></slot>
            </div>
        </div>

        <div class="flex justify-end space-x-2">
            <slot name="botones"></slot>
        </div>
        
        <slot name="calificaciones"></slot>
    </div>
</template>