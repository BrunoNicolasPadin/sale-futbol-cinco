<template>
    <app-layout title="Partido">
        <div class="px-6">
            <h1 class="text-4xl text-center font-extrabold">{{ partido.nombre }}</h1>

            <ul class="my-6 list-disc">
                <li class="my-2">
                    <topico punto="Organizador" />
                    <Link :href="route('perfil.mostrar', partido.user.nombreUsuario)" class="hover:underline cursor-pointer">
                        {{ partido.user.name }}
                    </Link>
                </li>
                <li class="my-2">
                    <topico punto="Calificación como organizador" />
                    {{ partido.calificacionOrganizador[0] }}/10 - {{ partido.calificacionOrganizador[1] }} votos
                </li>
                <li class="my-2">
                    <topico punto="Precio" /> ${{ partido.precio }}
                </li>
                <li class="my-2">
                    <topico punto="Lugar" /> {{ partido.lugar }}
                </li>
                <li class="my-2">
                    <topico punto="Horario en que finaliza la busqueda" /> {{ partido.fechaHoraFinalizacion }}
                </li>
                <li class="my-2">
                    <topico punto="Cantidad de jugadores necesarios" /> {{ partido.cuantosFaltan }}
                </li>
                <li class="my-2">
                    <topico punto="Tipo de cancha" /> {{ partido.tipoDeCancha }}
                </li>
                <li class="my-2">
                    <topico punto="Estado del anuncio" /> {{ partido.estado }}
                </li>
                <li class="my-2">
                    <topico punto="Detalles" /> <p class="whitespace-pre-line">{{ partido.detalles }}</p>
                </li>
                <li class="my-2">
                    <topico punto="Calificación" /> {{ calificacion['puntaje'] }}/10 - 
                    <topico punto="Votos" /> {{ calificacion['cantidad'] }}
                </li>
                <li class="my-2">
                    <button type="button" @click="verCalificaciones()"
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-blue-600 text-white hover:bg-blue-800 hover:shadow-lg">
                        Ver calificaciones del partido
                    </button>
                </li>
                <li v-if="presentoPostulacion" class="my-2">
                    <topico punto="Tu estado" />{{ postulacion.estado }}
                </li>
                <li v-if="partido.user_id != user_id && user_id != null " class="my-2">
                    <button v-if="presentoPostulacion == false && partido.estado == 'Buscando jugadores' " type="button" @click="quieroJugar()"
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-blue-600 text-white hover:bg-blue-800 hover:shadow-lg">
                        Quiero jugar
                    </button>

                    <button v-else-if="presentoPostulacion == true" type="button" @click="noQuieroJugar()"
                        class="px-2.5 py-2.5 rounded-sm shadow-md bg-red-600 text-white hover:bg-red-800 hover:shadow-lg">
                        No quiero jugar
                    </button>
                </li>
            </ul>

            <div v-if="partido.user_id == user_id" class="mt-10 flex justify-end">
                <div class="flex flex-wrap space-x-2">
                    <button type="button" @click="verPostulantesAceptados()"
                        class="px-2.5 py-2.5 my-2 rounded-sm shadow-md bg-pink-600 text-white hover:bg-pink-800 hover:shadow-lg">
                        Ver aceptados
                    </button>

                    <button type="button" @click="verPostulantes()"
                        class="px-2.5 py-2.5 my-2 rounded-sm shadow-md bg-blue-600 text-white hover:bg-blue-800 hover:shadow-lg">
                        Ver postulantes
                    </button>

                    <button type="button" @click="editar()" 
                        class="px-2.5 py-2.5 my-2 rounded-sm shadow-md bg-yellow-400 text-white hover:bg-yellow-500 hover:shadow-lg">
                        Editar
                    </button>

                    <button type="button" @click="eliminar()" 
                        class="px-2.5 py-2.5 my-2 rounded-sm shadow-md bg-red-400 text-white hover:bg-red-500 hover:shadow-lg">
                        Eliminar
                    </button>
                </div>
            </div>

            <!-- Postulaciones -->
            <div v-if="mostrarPostulaciones" class="relative mt-6 mx-auto">

                <div v-for="postulacion in postulaciones" :key="postulacion.id">
                    <listado-resultados>
                        <template #cabecera>
                            {{ postulacion.partidos }} partidos - Puntaje promedio: {{ postulacion.puntaje }}/10
                        </template>

                        <template #nombre>
                            <Link :href="route('perfil.mostrar', postulacion.nombreUsuario)" class="hover:underline cursor-pointer">
                                {{ postulacion.nombre }}
                            </Link>
                        </template>

                        <template #botones>
                            <button type="button" @click="actualizarPostulacion(postulacion.id, 'Esperando respuesta')"
                                class="px-2.5 py-2.5 rounded-sm shadow-md bg-green-600 text-white hover:bg-green-800 hover:shadow-lg">
                                Aceptar
                            </button>
                        </template>
                    </listado-resultados>

                    <hr class="bg-gray-300 p-px">
                </div>
            </div>

            <!-- Postulantes aceptados -->
            <div v-if="mostrarPostulantesAceptados" class="relative mt-6 mx-auto">
                <div v-for="postulanteAceptado in postulantesAceptados" :key="postulanteAceptado.id">
                    <listado-resultados>
                        <template #cabecera>
                            {{ postulanteAceptado.partidos }} partidos - Puntaje promedio: {{ postulanteAceptado.puntaje }}/10
                        </template>

                        <template #nombre>
                            <Link :href="route('perfil.mostrar', postulanteAceptado.nombreUsuario)" class="hover:underline cursor-pointer">
                                {{ postulanteAceptado.nombre }}
                            </Link>
                        </template>

                        <template #botones>
                            <button type="button" @click="calificarPostulacion(postulanteAceptado.id)"
                                class="px-2.5 py-2.5 rounded-sm shadow-md bg-indigo-600 text-white hover:bg-indigo-800 hover:shadow-lg">
                                Calificar
                            </button>

                            <button type="button" @click="actualizarPostulacion(postulanteAceptado.id, 'Aceptado')"
                                class="px-2.5 py-2.5 rounded-sm shadow-md bg-green-600 text-white hover:bg-green-800 hover:shadow-lg">
                                Dejarlo en espera
                            </button>
                        </template>
                    </listado-resultados>

                    <hr class="bg-gray-300 p-px">
                </div>
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
    import ListadoResultados from '@/Shared/Buscador/ListadoResultados.vue'
    import Topico from '@/Shared/Listas/Topico.vue'

    export default defineComponent({
            components: {
            AppLayout,
            EstructuraInputVue,
            InputComponenteVue,
            Link,
            ListadoResultados,
            Topico,
        },

        props: {
            partido: Object,
            user_id: String,
            presentoPostulacion: Boolean,
            postulacion: Object,
            calificacion: Array,
        },

        data() {
            return {
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
                if (confirm('¿Estás seguro de que deseas querer jugar este partido?')) {
                    this.$inertia.post(this.route('postulaciones.store', this.partido.slug))
                }
            },

            noQuieroJugar() {
                if (confirm('¿Estás seguro de que deseas eliminar tu postulación?')) {
                    this.$inertia.delete(this.route('postulaciones.destroy', [this.partido.slug, this.postulacion.id]))
                }
            },

            verPostulantes() {
                this.formBuscador.page = 1
                axios.get(this.route('postulaciones.index', this.partido.slug), this.formBuscador)
                .then(response => {
                    this.postulaciones = response.data
                    this.mostrarPostulantesAceptados = false
                    this.mostrarPostulaciones = true
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            actualizarPostulacion(postulacion_id, estado) {
                var mensaje = null
                if (estado == 'Esperando respuesta') {
                    this.formActualizarPostulacion.estado = 'Aceptado'
                    mensaje = 'aceptar'
                } else {
                    this.formActualizarPostulacion.estado = 'Esperando respuesta'
                    mensaje = 'dejar en espera'
                }
                if (confirm('¿Estás seguro de que deseas '+ mensaje +' este jugador?')) {
                    this.$inertia.put(this.route('postulaciones.update', [this.partido.slug, postulacion_id]), this.formActualizarPostulacion)
                }
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

            calificarPostulacion(postulanteAceptado_id) {
                this.$inertia.get(this.route('postulaciones.show', [this.partido.slug, postulanteAceptado_id]))
            },

            verCalificaciones() {
                this.$inertia.get(this.route('calificaciones.index', this.partido.slug))
            },
        }
    })
</script>