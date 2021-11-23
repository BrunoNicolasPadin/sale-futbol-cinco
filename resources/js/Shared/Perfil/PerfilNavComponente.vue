<template>
    <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 bg-gray-400 shadow-lg mb-3">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto  px-4 lg:static lg:block lg:justify-start">
                <span class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white">
                    <Link :href="route('perfil.mostrar', usuario.nombreUsuario)" class="hover:opacity-75">
                        {{ usuario.name }}
                    </Link> - {{ usuario.numero }}
                </span>
                <button class="text-white cursor-pointer text-xl leading-none border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button" @click="toggleNavbar()">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div v-bind:class="{'hidden': !showMenu, 'flex': showMenu}" class="lg:flex lg:flex-grow items-center">
                <ul class="flex flex-col lg:flex-row list-none ml-auto">
                    <li class="nav-item">
                        <Link :href="route('perfil.partidosOrganizados', usuario.nombreUsuario)" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                            <span class="ml-2">Partidos organizados</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('perfil.postulacionesAceptadas', usuario.nombreUsuario)" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                            <span class="ml-2">Postulaciones aceptadas</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('perfil.postulacionesEnEspera', usuario.nombreUsuario)" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                            <span class="ml-2">Postulaciones en espera</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },

        props: {
            usuario: Object,
        },

        data() {
            return {
                showMenu: false
            }
        },

        methods: {
            toggleNavbar: function(){
                this.showMenu = !this.showMenu;
            }
        }
    })
</script>