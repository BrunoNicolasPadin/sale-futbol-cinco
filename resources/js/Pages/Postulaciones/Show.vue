<template>
    <app-layout title="Postulacion - Calificación">

        <div class="my-3 text-3xl">
            <Link :href="route('partidos.show', partido.slug)" class="hover:underline">
                {{ partido.nombre }}
            </Link> / Postulación de {{ postulacion.user.name }}
        </div>

        <hr class="bg-gray-300 p-px">

        <listado-calificaciones v-if="postulacion.puntaje != null && mostrarCajaParaCalificar == false " :comentario='postulacion.comentario'
            :user_id='user_id' :objeto='partido'>
            <template #titulo-cabecera>
                Calificación
            </template>

            <template #calificacion-cabecera>
                {{ postulacion.puntaje }}/10
            </template>

            <template #botones>
                <button type="button" @click="editarCalificacion()" 
                    class="mr-2 focus:outline-none text-white font-bold text-base py-2 px-4 bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg">
                        Editar
                </button>

                <button type="button" @click="eliminarCalificacion()" 
                    class="focus:outline-none text-white font-bold text-base py-2 px-4 bg-red-500 hover:bg-red-600 hover:shadow-lg">
                        Eliminar
                </button>
            </template>
        </listado-calificaciones>

        <div v-else class="my-6">
            <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Calificar postulante</h2>
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

                <guardar />
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
        },

        data() {
            return {
                mostrarCajaParaCalificar: false,
                form: {
                    puntaje: null,
                    comentario: null,
                },
            }
        },

        methods: {
            submit() {
                this.mostrarCajaParaCalificar = false
                this.$inertia.put(this.route('postulaciones.calificar', [this.partido.slug, this.postulacion.id]), this.form)
            },

            editarCalificacion() {
                this.mostrarCajaParaCalificar = true
                this.form.puntaje = this.postulacion.puntaje
                this.form.comentario = this.postulacion.comentario
            },

            eliminarCalificacion() {
                if (confirm('¿Estás seguro de que deseas eliminar esta calificación?')) {
                    this.$inertia.delete(this.route('postulaciones.eliminarCalificacion', [this.partido.slug, this.postulacion.id]))
                }
            }
        }
    })
</script>
