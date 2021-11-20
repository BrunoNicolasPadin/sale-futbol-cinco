<template>
    <app-layout title="Partidos - Agregar">
        <template #header>
            Partidos
        </template>

        <!-- Formulario -->
        <form method="post" @submit.prevent="submit">
            <estructura-formulario-vue class="grid grid-cols-1 lg:grid-cols-2 gap-y-3 lg:gap-x-3">
                <template #estructuraInput>
                    <estructura-input-vue nombreLabel="Nombre" info="Es obligatorio.">
                        <template #inputComponente>
                            <input-componente-vue type="text" v-model="form.nombre" autofocus required/>
                        </template>
                    </estructura-input-vue>

                    <estructura-input-vue nombreLabel="Fecha y hora de finalización de la búsqueda" 
                        info="Es obligatorio. Formato: DD/MM/AAAA HH:MM:SS. EJ: 09-12-2021 18:30:00">
                        <template #inputComponente>
                            <input-componente-vue type="text" v-model="form.fechaHoraFinalizacion" required placeholder="09-12-2021 18:30:00"/>
                        </template>
                    </estructura-input-vue>
                </template>
            </estructura-formulario-vue>

            <estructura-formulario-vue class="grid grid-cols-1 lg:grid-cols-2 gap-y-3 lg:gap-x-3">
                <template #estructuraInput>
                    <estructura-input-vue nombreLabel="Lugar" info="Es obligatorio.">
                        <template #inputComponente>
                            <input-componente-vue type="text" v-model="form.lugar" required 
                                placeholder="Amundsen 1234, Canchas el triangulo, Rosario"/>
                        </template>
                    </estructura-input-vue>

                    <estructura-input-vue nombreLabel="Cantidad de jugadores que necesita" info="Es obligatorio. Solo números.">
                        <template #inputComponente>
                            <input-componente-vue type="text" v-model="form.cuantosFaltan" required placeholder="2"/>
                        </template>
                    </estructura-input-vue>
                </template>
            </estructura-formulario-vue>

            <estructura-formulario-vue>
                <template #estructuraInput>
                    <estructura-input-vue nombreLabel="Precio" info="Es obligatorio y sin simbolos de la moneda, solo números.">
                        <template #inputComponente>
                            <input-componente-vue type="text" v-model="form.precio" required 
                                placeholder="500"/>
                        </template>
                    </estructura-input-vue>
                </template>
            </estructura-formulario-vue>

            <estructura-formulario-vue class="grid grid-cols-1 lg:grid-cols-2 gap-y-3 lg:gap-x-3">
                <template #estructuraInput>
                    <estructura-input-vue nombreLabel="Tipo de cancha" info="Es obligatorio.">
                        <template #inputComponente>
                            <select v-model="form.tipoDeCancha" class="w-full rounded-md">
                                <option disabled selected value="null">Seleccionar tipo de cancha</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="9">9</option>
                                <option value="11">11</option>
                            </select>
                        </template>
                    </estructura-input-vue>

                    <estructura-input-vue nombreLabel="Estado del partido" info="Es obligatorio.">
                        <template #inputComponente>
                            <select v-model="form.estado" class="w-full rounded-md">
                                <option disabled selected value="null">Seleccionar estado del partido</option>
                                <option value="Buscando jugadores">Buscando jugadores</option>
                                <option value="Busqueda finalizada">Búsqueda finalizada</option>
                            </select>
                        </template>
                    </estructura-input-vue>
                </template>
            </estructura-formulario-vue>

            <estructura-formulario-vue>
                <template #estructuraInput>
                    <estructura-input-vue nombreLabel="Detalles adicionales" info="No es obligatorio.">
                        <template #inputComponente>
                            <textarea v-model="form.detalles" class="w-full" rows="5"></textarea>
                        </template>
                    </estructura-input-vue>
                </template>
            </estructura-formulario-vue>

            <guardar />

        </form>
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

        data() {
            return {
                form: {
                    nombre: null,
                    fechaHoraFinalizacion: null,
                    lugar: null,
                    cuantosFaltan: null,
                    precio: null,
                    tipoDeCancha: null,
                    estado: null,
                    detalles: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('partidos.store'), this.form);
            },
        }
    })
</script>