<template>
    <app-layout title="Perfil">
        <perfil-nav-componente :usuario="usuario" />

        <h1 class="text-3xl font-bold my-3">
            <span v-if="postulacionesAceptadas">Postulaciones aceptadas</span>
            <span v-else>Postulaciones en espera</span>
        </h1>

        <div v-for="partido in partidosFiltrados.data" :key="partido.id">
            <div class="my-3 bg-white shadow-md rounded-md p-4">
                <div class="text-base">
                    <span class="font-semibold text-green-800">
                        <Link :href="route('perfil.mostrar', partido.user.nombreUsuario)" class="hover:underline">
                            {{ partido.user.name }}
                        </Link>
                    </span>
                </div>
                
                <h1 class="text-2xl font-black mt-3">
                    <Link :href="route('partidos.show', partido.slug)" class="hover:underline">
                        {{ partido.nombre }}
                    </Link>
                </h1>

                <div class="text-base">
                    <div class="flex flex-wrap space-x-2">
                        <div class="text-blue-900 rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                            {{ partido.cuantosFaltan }} jugadores
                        </div>
                        <div class="text-blue-900 rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                            ${{ partido.precio }}
                        </div>
                        <div class="text-blue-900 rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                            Cancha de {{ partido.tipoDeCancha }}
                        </div>
                        <div class="text-blue-900 rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                            {{ partido.fechaHoraFinalizacion }}
                        </div>
                        <div v-if="partido.estado == 'Buscando jugadores' " 
                            class="text-blue-900 rounded-full bg-blue-50 border border-blue-200 p-2 mt-6">
                            {{ partido.estado }}
                        </div>
                        <div v-else 
                            class="text-white rounded-full bg-red-700 border border-red-200 p-2 mt-6">
                            {{ partido.estado }}
                        </div>
                    </div>
                </div>

                <hr class="bg-gray-100 p-px my-3">

                <h1 v-if="partido.puntajeRecibido"><span class="font-bold">Puntaje recibido</span>: {{ partido.puntajeRecibido }}/10</h1>
                <h1 v-else>Aún no recibió puntaje su postulación</h1>

                <hr class="bg-gray-100 p-px my-3">

                <h1 v-if="partido.puntajeDado"><span class="font-bold">Puntaje al partido dado por {{ usuario.name }}</span>: 
                {{ partido.puntajeDado.puntaje }}/10</h1>
                <h1 v-else>Aún no calificó el partido</h1>
            </div>

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

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            EstructuraInputVue,
            InputComponenteVue,
            PerfilNavComponente
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
