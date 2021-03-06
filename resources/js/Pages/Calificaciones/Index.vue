<template>
    <app-layout title="Partido - Calificación">

        <div class="my-3 text-3xl">
            <Link :href="route('partidos.show', partido.slug)" class="hover:underline">
                {{ partido.nombre }}
            </Link> / Calificaciones
        </div>

        <hr class="bg-gray-300 p-px">

        <div v-for="calificacion in calificaciones" :key="calificacion.id">

            <listado-calificaciones :comentario='calificacion.comentario' :user_id='user_id' :objeto='calificacion'>
                <template #titulo-cabecera>
                    <Link :href="route('perfil.mostrar', calificacion.user.nombreUsuario)" class="hover:underline">
                        {{ calificacion.user.name }}
                    </Link> - Calificación
                </template>

                <template #calificacion-cabecera>
                    {{ calificacion.puntaje }}/10
                </template>

                <template #botones>
                    <button type="button" @click="editarCalificacion(calificacion)" 
                        class="mr-2 focus:outline-none text-white font-bold text-base py-2 px-4 bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg">
                            Editar
                    </button>

                    <button type="button" @click="eliminarCalificacion(calificacion)" 
                        class="focus:outline-none text-white font-bold text-base py-2 px-4 bg-red-500 hover:bg-red-600 hover:shadow-lg">
                            Eliminar
                    </button>
                </template>
            </listado-calificaciones>

        </div>

        <div v-if="postulacion != null && mostrarCajaParaCalificar == true " class="my-3">
            <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Calificar partido</h2>
            <form method="post" @submit.prevent="submit">
                <estructura-formulario-vue>
                    <template #estructuraInput>
                        <estructura-input-vue nombreLabel="Puntaje del 1 al 10" info="Es obligatorio.">
                            <template #inputComponente>
                                <input-componente-vue type="Number" v-model="form.puntaje" autofocus required/>
                            </template>
                        </estructura-input-vue>
                    </template>
                </estructura-formulario-vue>

                <estructura-formulario-vue>
                    <template #estructuraInput>
                        <estructura-input-vue nombreLabel="Comentario" info="No es obligatorio.">
                            <template #inputComponente>
                                <textarea v-model="form.comentario" class="w-full" rows="5" placeholder="Escribir comentario..."></textarea>
                            </template>
                        </estructura-input-vue>
                    </template>
                </estructura-formulario-vue>

                <guardar v-if="mostrarBotonGuardar" />

                <button v-else @click="actualizarCalificacion(calificacion_editar_id)" 
                    type="button" 
                    class="mt-3 focus:outline-none text-white text-sm py-2.5 px-5 rounded-md bg-green-500 hover:bg-green-600 hover:shadow-lg">
                    Actualizar
                </button>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraFormularioVue from '@/Shared/Formulario/EstructuraFormulario.vue'
    import EstructuraInputVue from '@/Shared/Formulario/EstructuraInput.vue'
    import InputComponenteVue from '@/Shared/Formulario/InputComponente.vue'
    import Guardar from '@/Shared/Botones/Guardar'
    import { Link } from '@inertiajs/inertia-vue3';
    import ListadoCalificaciones from '@/Shared/Calificaciones/ListadoCalificaciones.vue'

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraFormularioVue,
            EstructuraInputVue,
            InputComponenteVue,
            Guardar,
            Link,
            ListadoCalificaciones,
        },

        props: {
            partido: Object,
            postulacion: Object,
            user_id: String,
            calificacionDelPostulado: Boolean,
            calificaciones: Array,
        },

        data() {
            return {
                mostrarCajaParaCalificar: false,
                form: {
                    puntaje: null,
                    comentario: null,
                },
                calificacion_editar_id: null,
                mostrarBotonGuardar: true,
            }
        },

        mounted() {
            if (this.calificacionDelPostulado == false) {
                this.mostrarCajaParaCalificar = true
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('calificaciones.store', this.partido.slug), this.form)
                this.mostrarCajaParaCalificar = false

            },

            editarCalificacion(calificacion) {
                this.mostrarCajaParaCalificar = true
                this.mostrarBotonGuardar = false
                this.form.puntaje = calificacion.puntaje
                this.form.comentario = calificacion.comentario
                this.calificacion_editar_id = calificacion.id
            },

            actualizarCalificacion(calificacion_id) {
                this.$inertia.put(this.route('calificaciones.update', [this.partido.slug, calificacion_id]), this.form)
                this.mostrarCajaParaCalificar = false
                this.mostrarBotonGuardar = true
            },

            eliminarCalificacion(calificacion_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta calificación?')) {
                    this.$inertia.delete(this.route('calificaciones.destroy', [this.partido.slug, calificacion_id]))
                    this.mostrarCajaParaCalificar = true
                }
            }
        }
    })
</script>
