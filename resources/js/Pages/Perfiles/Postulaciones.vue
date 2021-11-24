<template>
    <app-layout title="Perfil">
        <perfil-nav-componente :usuario="usuario" />

        <titulo-listado v-if="postulacionesAceptadas" titulo='Postulaciones aceptadas' />
        <titulo-listado v-else titulo='Postulaciones en espera' />

        <hr class="bg-gray-300 p-px my-3">

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

                    <h1 v-if="partido.puntajeRecibido">
                        <span class="font-bold">Puntaje recibido</span>: {{ partido.puntajeRecibido }}/10
                    </h1>
                    <h1 v-else>Aún no recibió puntaje su postulación</h1>

                    <hr class="bg-gray-100 p-px my-3">

                    <h1 v-if="partido.puntajeDado">
                        <span class="font-bold">Puntaje al partido dado por {{ usuario.name }}</span>: {{ partido.puntajeDado.puntaje }}/10
                    </h1>
                    <h1 v-else>Aún no calificó el partido</h1>
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
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import EstructuraInputVue from '@/Shared/Formulario/EstructuraInput.vue'
    import InputComponenteVue from '@/Shared/Formulario/InputComponente.vue'
    import PerfilNavComponente from '@/Shared/Perfil/PerfilNavComponente.vue';
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
            ListadoResultados,
            DetallesResultado,
            TituloListado,
        },

        props: {
            usuario: Object,
            partidos: Object,
            postulacionesAceptadas: Boolean,
        },

        mounted() {
            if (this.postulacionesAceptadas == false) {
                this.formBuscador.estado = 'Esperando respuesta'
            }
        },

        data() {
            return {
                showMenu: false,
                isOpen: false,
                partidosFiltrados: this.partidos,
                formBuscador: {
                    page: 1,
                    estado: 'Aceptado',
                },
            }
        },
        methods: {
            toggleNavbar: function(){
                this.showMenu = !this.showMenu;
            },

            openModal: function () {
                this.isOpen = true;
            },

            closeModal: function () {
                this.isOpen = false;
            },

            otraPagina(index) {
                this.formBuscador.page = index
                axios.post(this.route('perfil.filtrarPostulaciones', this.usuario.nombreUsuario), this.formBuscador)
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
