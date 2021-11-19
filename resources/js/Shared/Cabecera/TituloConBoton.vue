<template>
    <div class="my-4 grid grid-cols-2">
        <div class="flex justify-first">
            <span class="text-3xl">
                <slot name="titulo"></slot>
            </span>
        </div>
        <div class="flex justify-end">
            <button type="button" class="float-right border border-blue-500 bg-blue-500 text-white font-bold rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                <slot name="boton"></slot>
            </button>
        </div>
    </div>

    <hr class="bg-black p-px mt-2 mb-4">
</template>