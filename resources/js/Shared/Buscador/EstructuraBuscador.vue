<template>
    <div class="overflow-hidden sm:rounded-lg">
        <div class="flex flex-col items-center text-center justify-end h-3/4">
            <div>
                <h1 class="text-4xl text-black font-semibold leading-none py-5">
                    {{ titulo }}
                </h1>
            </div>
            <div class="w-full my-2">
                <div class="relative">
                    <svg class="absolute top-0 mt-6 ml-6 w-8 h-8 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <slot name="buscador-input"></slot>
                    <!-- <input class="text-2xl placeholder-gray-600 text-gray-800 pb-4 pt-5 pl-20 pr-4 rounded w-full border-b-4 focus:outline-none focus:border-blue-800" 
                    type="text" 
                    placeholder="Buscar..."> -->
                </div>
                <div class="my-2 flex sm:flex-row flex-col">
                    <div class="flex flex-row mb-1 sm:mb-0">
                        <slot name="filtros"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        titulo: String,
    },
}
</script>