<template>
    <app-layout title="Partido">
        <div class="px-6">
            <h1 class="text-4xl text-center font-extrabold">{{ partido.nombre }}</h1>

            <ul class="list-disc">
                <li class="my-2">Precio: <span class="font-bold text-blue-900">${{ partido.precio }}</span></li>
                <li class="my-2">Lugar: <span class="font-bold text-blue-900">{{ partido.lugar }}</span></li>
                <li class="my-2">Horario: <span class="font-bold text-blue-900">{{ partido.fechaHoraFinalizacion }}</span></li>
                <li class="my-2">Faltan <span class="font-bold text-blue-900">{{ partido.cuantosFaltan }}</span> jugadores</li>
                <li class="my-2"><span class="font-bold text-blue-900">Cancha de {{ partido.tipoDeCancha }}</span></li>
                <li class="my-2">Estado del anuncio: <span class="font-bold text-blue-900">{{ partido.estado }}</span></li>
                <li class="my-2">Detalles: <p class="font-bold text-blue-900 whitespace-pre-line">{{ partido.detalles }}</p></li>
                <li v-if="presentoPostulacion" class="my-2">Tu estado: <span class="font-bold text-blue-900">{{ postulacion.estado }}</span></li>
                <li v-if="partido.user_id != user_id && user_id != null " class="my-2">
                    <button v-if="presentoPostulacion == false " type="button" @click="quieroJugar()"
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-blue-600 text-white hover:bg-blue-800 hover:shadow-lg">
                        Quiero jugar
                    </button>

                    <button v-else type="button" @click="noQuieroJugar()"
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-red-600 text-white hover:bg-red-800 hover:shadow-lg">
                        No quiero jugar
                    </button>
                </li>
            </ul>

            <div v-if="partido.user_id == user_id" class="mt-10 flex justify-end">
                <div class="flex space-x-2">
                    <button type="button" @click="verPostulantesAceptados()"
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-pink-600 text-white hover:bg-pink-800 hover:shadow-lg">
                        Ver aceptados
                    </button>

                    <button type="button" @click="verPostulantes()"
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-blue-600 text-white hover:bg-blue-800 hover:shadow-lg">
                        Ver postulantes
                    </button>

                    <button type="button" @click="editar()" 
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-yellow-400 text-white hover:bg-yellow-500 hover:shadow-lg">
                        Editar
                    </button>

                    <button type="button" @click="eliminar()" 
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-red-400 text-white hover:bg-red-500 hover:shadow-lg">
                        Eliminar
                    </button>
                </div>
            </div>

            <!-- Postulaciones -->
            <div v-if="mostrarPostulaciones" class="relative mt-6 mx-auto">

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
                                    <estructura-input-vue nombreLabel="Calificación" class="my-2">
                                        <template #inputComponente>
                                            <select class="w-full rounded-md" v-model="formBuscador.calificacion">
                                                <option disabled selected value="null">Seleccionar calificación</option>
                                                <option value="5">5</option>
                                                <option value="4">4 o más</option>
                                                <option value="3">3 o más</option>
                                                <option value="2">2 o más</option>
                                                <option value="1">1 o más</option>
                                                <option value="0">0 o más</option>
                                            </select>
                                        </template>
                                    </estructura-input-vue>

                                    <div class="grid grid-cols-2 gap-x-2">
                                        <button @click="verPostulantes()" type="button" class="mt-2 inline-flex justify-center w-full rounded-md border px-4 py-2 border-gray-300 bg-green-300 hover:bg-green-400 text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
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

                <div v-for="postulacion in postulacionesFiltradas.data" :key="postulacion.id">
                    <div class="my-3 bg-white shadow-md rounded-md p-4">
                        <div class="text-sm grid grid-cols-2">
                            <div class="flex space-x-2">
                                <span class="font-semibold text-green-800">
                                    43 partidos jugados
                                </span>
                                <span>
                                    -
                                </span>
                                <span>
                                    4.2/5
                                </span>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl font-black mt-3">
                            {{ postulacion.user.name }}
                        </h1>

                        <div class="flex justify-end">
                            <button type="button" @click="actualizarPostulacion(postulacion.id, 'Esperando respuesta')"
                                class="px-2.5 py-2.5 rounded-sm shadow-md bg-green-600 text-white hover:bg-green-800 hover:shadow-lg">
                                Aceptar
                            </button>
                        </div>
                    </div>

                    <hr class="bg-gray-200 p-px">
                </div>
                
                <!-- Paginador -->
                <div class="flex flex-wrap my-3">
                    <template v-for="(link, index, key) in postulacionesFiltradas.links" :key="key">
                        <button @click="otraPagina(link.label)" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-white': link.active }" v-html="link.label" />
                    </template>
                </div>
            </div>

            <!-- Postulantes aceptados -->
            <div v-if="mostrarPostulantesAceptados" class="relative mt-6 mx-auto">
                <div v-for="postulanteAceptado in postulantesAceptados" :key="postulanteAceptado.id">
                    <div class="my-3 bg-white shadow-md rounded-md p-4">
                        <div class="text-sm grid grid-cols-2">
                            <div class="flex space-x-2">
                                <span class="font-semibold text-green-800">
                                    43 partidos jugados
                                </span>
                                <span>
                                    -
                                </span>
                                <span>
                                    4.2/5
                                </span>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl font-black mt-3">
                            {{ postulanteAceptado.user.name }}
                        </h1>

                        <div v-if="partido.user_id == user_id" class="flex justify-end">
                            <button type="button" @click="actualizarPostulacion(postulanteAceptado.id, 'Aceptado')"
                                class="px-2.5 py-2.5 rounded-sm shadow-md bg-green-600 text-white hover:bg-green-800 hover:shadow-lg">
                                Dejarlo en espera
                            </button>
                        </div>
                    </div>

                    <hr class="bg-gray-200 p-px">
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import EstructuraInputVue from '@/Shared/Formulario/EstructuraInput.vue'
    import InputComponenteVue from '@/Shared/Formulario/InputComponente.vue'

    export default defineComponent({
            components: {
            AppLayout,
            Link,
            EstructuraInputVue,
            InputComponenteVue,
        },

        props: {
            partido: Object,
            user_id: String,
            presentoPostulacion: Boolean,
            postulacion: Object,
        },

        data() {
            return {
                isOpen: false,
                postulacionesFiltradas: null,
                formBuscador: {
                    page: 1,
                    calificacion: null,
                },
                mostrarPostulaciones: false,
                mostrarPostulantesAceptados: false,
                formActualizarPostulacion: {
                    estado: null,
                },
                postulantesAceptados: null,
            }
        },

        methods: {
            editar() {
                this.$inertia.get(this.route('partidos.edit', this.partido.slug))
            },

            eliminar() {
                if (confirm('¿Estás seguro de que deseas eliminar este partido?')) {
                    this.$inertia.delete(this.route('partidos.destroy', this.partido.slug));
                }
            },

            quieroJugar() {
                this.$inertia.post(this.route('postulaciones.store', this.partido.id))
            },

            noQuieroJugar() {
                this.$inertia.delete(this.route('postulaciones.destroy', [this.partido.id, this.postulacion.id]))
            },

            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
            },

            verPostulantes() {
                this.formBuscador.page = 1
                axios.get(this.route('postulaciones.index', this.partido.slug), this.formBuscador)
                .then(response => {
                    this.postulacionesFiltradas = response.data
                    this.mostrarPostulantesAceptados = false
                    this.mostrarPostulaciones = true
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            otraPagina(index) {
                this.formBuscador.page = index
                axios.get(this.route('postulaciones.index', this.partido.slug), this.formBuscador)
                .then(response => {
                    this.postulacionesFiltradas = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            actualizarPostulacion(postulacion_id, estado) {
                if (estado == 'Esperando respuesta') {
                    this.formActualizarPostulacion.estado = 'Aceptado'
                } else {
                    this.formActualizarPostulacion.estado = 'Esperando respuesta'
                }

                this.$inertia.put(this.route('postulaciones.update', [this.partido.slug, postulacion_id]), this.formActualizarPostulacion)
            },

            verPostulantesAceptados() {
                axios.get(this.route('postulaciones.aceptados', this.partido.slug))
                .then(response => {
                    this.postulantesAceptados = response.data
                    this.mostrarPostulaciones = false
                    this.mostrarPostulantesAceptados = true
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },
        }
    })
</script>