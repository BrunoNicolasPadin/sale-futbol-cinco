<template>
    <app-layout title="Perfil">
        <perfil-nav-componente :usuario="usuario" />

        <titulo-listado titulo='Partidos organizados' />

        <div class="relative mt-6 mx-auto">
            <input-buscador @escribir="buscar" v-model="formBuscador.nombre" />

            <filtro-componente @aplicarFiltros="buscar">
                <template #filtros>
                    <estructura-input-vue nombreLabel="Tipo de cancha" class="my-2">
                        <template #inputComponente>
                            <select class="w-full rounded-md" v-model="formBuscador.tipoDeCancha">
                                <option disabled selected value="">Seleccionar tipo de cancha</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="9">9</option>
                                <option value="11">11</option>
                            </select>
                        </template>
                    </estructura-input-vue>

                    <estructura-input-vue nombreLabel="Estado" class="my-2">
                        <template #inputComponente>
                            <select class="w-full rounded-md" v-model="formBuscador.estado">
                                <option disabled selected value="">Seleccionar tipo de estado</option>
                                <option value="Buscando jugadores">Buscando jugadores</option>
                                <option value="Busqueda finalizada">Búsqueda finalizada</option>
                            </select>
                        </template>
                    </estructura-input-vue>

                    <estructura-input-vue nombreLabel="Cantidad de jugadores que necesitan">
                        <template #inputComponente>
                            <input-componente-vue type="number" v-model="formBuscador.cuantosFaltan"/>
                        </template>
                    </estructura-input-vue>

                    <estructura-input-vue nombreLabel="Fecha y hora. Formato: DD-MM-AAAA HH:MM:SS">
                        <template #inputComponente>
                            <input-componente-vue type="text" v-model="formBuscador.fechaHora"/>
                        </template>
                    </estructura-input-vue>
                </template>
            </filtro-componente>

            <hr class="bg-gray-300 p-px my-2">

            <div v-for="partido in partidosFiltrados.data" :key="partido.id">
                <listado-resultados>
                    <template #cabecera>
                        <Link :href="route('perfil.mostrar', partido.user.nombreUsuario)" class="hover:underline">
                            {{ partido.user.name }}
                        </Link>
                    </template>

                    <template #nombre>
                        <Link :href="route('partidos.show', partido.slug)" class="hover:underline">
                            {{ partido.nombre }}
                        </Link>
                    </template>

                    <template #opciones>
                        <detalles-resultado>
                            <template #contenido>
                                {{ partido.cuantosFaltan }} jugadores
                            </template>
                        </detalles-resultado>

                        <detalles-resultado>
                            <template #contenido>
                                ${{ partido.precio }}
                            </template>
                        </detalles-resultado>

                        <detalles-resultado>
                            <template #contenido>
                                Cancha de {{ partido.tipoDeCancha }}
                            </template>
                        </detalles-resultado>

                        <detalles-resultado>
                            <template #contenido>
                                {{ partido.fechaHoraFinalizacion }}
                            </template>
                        </detalles-resultado>

                        <detalles-resultado v-if="partido.estado == 'Buscando jugadores' ">
                            <template #contenido>
                                {{ partido.estado }}
                            </template>
                        </detalles-resultado>

                        <div v-else 
                            class="text-white rounded-full bg-red-700 border border-red-200 p-2 mt-6">
                            {{ partido.estado }}
                        </div>
                    </template>

                    <template #calificaciones>
                        <hr class="bg-gray-100 p-px my-3">
                        <h1>
                            <span class="font-bold">Calificación</span>: {{ partido.calificacion.puntaje }}/10 - 
                            <span class="font-bold">Votos</span>: {{ partido.calificacion.cantidad }}
                        </h1>
                    </template>
                </listado-resultados>

                <hr class="bg-gray-300 p-px">
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
    import { Link } from '@inertiajs/inertia-vue3';
    import EstructuraInputVue from '@/Shared/Formulario/EstructuraInput.vue'
    import InputComponenteVue from '@/Shared/Formulario/InputComponente.vue'
    import PerfilNavComponente from '@/Shared/Perfil/PerfilNavComponente.vue';
    import InputBuscador from '@/Shared/Buscador/InputBuscador'
    import FiltroComponente from '@/Shared/Buscador/FiltroComponente'
    import ListadoResultados from '@/Shared/Buscador/ListadoResultados'
    import DetallesResultado from '@/Shared/Buscador/DetallesResultado'
    import TituloListado from '@/Shared/Perfil/TituloListado.vue';

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            EstructuraInputVue,
            InputComponenteVue,
            PerfilNavComponente,
            InputBuscador,
            FiltroComponente,
            ListadoResultados,
            DetallesResultado,
            TituloListado,
        },

        props: {
            usuario: Object,
            partidos: Object,
        },

        data() {
            return {
                showMenu: false,
                partidosFiltrados: this.partidos,
                formBuscador: {
                    page: 1,
                    nombre: null,
                    tipoDeCancha: '',
                    cuantosFaltan: null,
                    user_id: this.usuario.id,
                    estado: '',
                    fechaHora: null,
                },
            }
        },
        methods: {
            toggleNavbar: function(){
                this.showMenu = !this.showMenu;
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
