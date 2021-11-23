<template>
    <app-layout title="Partidos - Listar">

        <div class="my-2">
            <button type="button" @click="publicarPartido()" 
                class="px-2.5 py-2.5 rounded-sm shadow-md bg-green-600 text-white font-semibold hover:bg-green-800 hover:shadow-lg">
                Publicar partido
            </button>
        </div>
        <!-- Buscador -->
        <div class="relative mt-6 mx-auto">
            <input 
                class="w-full border rounded-md pl-10 pr-4 py-2 focus:border-blue-500 focus:outline-none focus:shadow-outline" 
                type="text" 
                placeholder="Buscar partidos"
                v-model="formBuscador.nombre"
                @keyup="buscar()">

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
                                <estructura-input-vue nombreLabel="Tipo de cancha" class="my-2">
                                    <template #inputComponente>
                                        <select class="w-full rounded-md" v-model="formBuscador.tipoDeCancha">
                                            <option disabled selected value="null">Seleccionar tipo de cancha</option>
                                            <option value="5">5</option>
                                            <option value="7">7</option>
                                            <option value="9">9</option>
                                            <option value="11">11</option>
                                        </select>
                                    </template>
                                </estructura-input-vue>

                                <estructura-input-vue nombreLabel="Cantidad de jugadores que necesitan">
                                    <template #inputComponente>
                                        <input-componente-vue type="text" v-model="formBuscador.cuantosFaltan"/>
                                    </template>
                                </estructura-input-vue>

                                <div class="grid grid-cols-2 gap-x-2">
                                    <button @click="buscar()" type="button" class="mt-2 inline-flex justify-center w-full rounded-md border px-4 py-2 border-gray-300 bg-green-300 hover:bg-green-400 text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        Aplicar
                                    </button>
                                    <button @click="closeModal()" type="button" class="mt-2 inline-flex justify-center w-full rounded-md border px-4 py-2 border-gray-300 bg-red-300 hover:bg-red-400 text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-for="partido in partidosFiltrados.data" :key="partido.id">
                <div class="my-3 bg-white shadow-md rounded-md p-4">
                    <div class="text-base grid grid-cols-2">
                        <div class="flex space-x-2">
                            <span class="font-semibold text-green-800">
                                {{ partido.user.name }}
                            </span>
                        </div>
                        <div class="flex justify-end">
                            <span>Hace 2h</span>
                        </div>
                    </div>
                    
                    <h1 class="text-2xl font-black mt-3">
                        <Link :href="route('partidos.show', partido.slug)" class="hover:underline">
                            {{ partido.nombre }}
                        </Link>
                    </h1>

                    <div class="text-base">
                        <div class="flex flex-wrap space-x-2">
                            <div class="text-blue-900 text-black rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                                {{ partido.cuantosFaltan }} jugadores
                            </div>
                            <div class="text-blue-900 text-black rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                                ${{ partido.precio }}
                            </div>
                            <div class="text-blue-900 text-black rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                                Cancha de {{ partido.tipoDeCancha }}
                            </div>
                            <div class="text-blue-900 text-black rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                                {{ partido.fechaHoraFinalizacion }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="bg-gray-200 p-px">
            </div>
            
            <!-- Paginador -->
            <div class="flex flex-wrap my-3">
                <template v-for="(link, index, key) in partidosFiltrados.links" :key="key">
                    <button @click="otraPagina(link.label)" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-white': link.active }" v-html="link.label" />
                </template>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraInputVue from '@/Shared/Formulario/EstructuraInput.vue'
    import InputComponenteVue from '@/Shared/Formulario/InputComponente.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
            components: {
            AppLayout,
            EstructuraInputVue,
            InputComponenteVue,
            Link,
        },

        props: {
            partidos: Object,
        },

        data() {
            return {
                isOpen: false,
                partidosFiltrados: this.partidos,
                formBuscador: {
                    page: 1,
                    nombre: null,
                    tipoDeCancha: '',
                    cuantosFaltan: null,

                },
            }
        },

        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
            },

            publicarPartido() {
                this.$inertia.get(this.route('partidos.create'))
            },

            buscar() {
                this.formBuscador.page = 1
                axios.post(this.route('partidos.filtrarPartidos'), this.formBuscador)
                .then(response => {
                    this.partidosFiltrados = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            otraPagina(index) {
                this.formBuscador.page = index
                axios.post(this.route('partidos.filtrarPartidos'), this.formBuscador)
                .then(response => {
                    this.partidosFiltrados = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },
        }
    })
</script>