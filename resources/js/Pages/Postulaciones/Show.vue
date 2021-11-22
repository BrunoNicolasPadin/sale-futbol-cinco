<template>
    <app-layout title="Postulacion - Calificación">

        <div class="my-3 text-3xl font-black">
            {{ postulacion.user.name }}
        </div>

        <hr class="bg-gray-200 p-px">

        <div v-if="postulacion.puntaje != null && mostrarCajaParaCalificar == false " class="my-2">
            <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Calificación: {{ postulacion.puntaje }}</h2>
            <div v-if="postulacion.comentario">
                <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Comentario:</h2>
                <p class="whitespace-pre-line">{{ postulacion.comentario }}</p>
            </div>

            <div v-if="user_id == partido.user_id " class="my-6">
                <div class="flex justify-end">
                    <button type="button" @click="editarCalificacion()" 
                        class="mr-2 focus:outline-none text-white font-bold text-sm py-0.5 px-4 rounded-full bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg">
                            Editar
                    </button>

                    <button type="button" @click="eliminarCalificacion()" 
                        class="focus:outline-none text-white font-bold text-sm py-0.5 px-4 rounded-full bg-red-500 hover:bg-red-600 hover:shadow-lg">
                            Eliminar
                    </button>
                </div>
            </div>
        </div>

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

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraFormularioVue,
            EstructuraInputVue,
            InputComponenteVue,
            Guardar,
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
