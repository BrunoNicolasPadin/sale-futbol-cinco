<template>
    <button type="button" @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded my-3">Abrir filtros</button>
    <div class="my-2 flex sm:flex-row flex-col">
        <div class="flex flex-row mb-1 sm:mb-0">
            <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                    <div class="px-4 py-2 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <slot name="filtros"></slot>

                        <div class="grid grid-cols-2 gap-x-2">
                            <button @click="$emit('aplicarFiltros')" type="button" class="mt-2 inline-flex justify-center w-full rounded-md border px-4 py-2 border-gray-300 bg-green-300 hover:bg-green-400 text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Aplicar filtros
                            </button>
                            <button @click="closeModal" type="button" class="mt-2 inline-flex justify-center w-full rounded-md border px-4 py-2 border-gray-300 bg-red-300 hover:bg-red-400 text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        data() {
            return {
                isOpen: false,
            }
        },

        emits: ['aplicar'],

        methods: {
            openModal: function () {
                this.isOpen = true;
            },

            closeModal: function () {
                this.isOpen = false;
            },
        }
    })
</script>