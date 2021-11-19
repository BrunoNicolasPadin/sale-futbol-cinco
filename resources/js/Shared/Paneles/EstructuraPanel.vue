<template>
    <app-layout>
        <div class="flex h-screen bg-green-100 font-roboto rounded-md border">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
                class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
    
            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
                class="fixed z-30 inset-y-0 left-0 w-60 transition duration-300 transform bg-gray-100 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 rounded-md">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <span class="text-gray-800 text-2xl font-semibold">Admin panel</span>
                    </div>
                </div>
    
                <nav class="flex flex-col mt-10 px-4 text-center">
                    <Link :href="route('paneles.listarCompetencias')"
                    class="mt-3 py-2 text-sm text-gray-600 hover:text-gray-700 hover:bg-gray-200 rounded">
                        Competencias
                    </Link>

                    <Link :href="route('paneles.listarEquipos')"
                    class="mt-3 py-2 text-sm text-gray-600 hover:text-gray-700 hover:bg-gray-200 rounded">
                        Equipos
                    </Link>

                    <Link :href="route('paneles.listarJugadores')"
                    class="mt-3 py-2 text-sm text-gray-600 hover:text-gray-700 hover:bg-gray-200 rounded">
                        Jugadores
                    </Link>

                    <Link :href="route('paneles.listarDirectores')"
                    class="mt-3 py-2 text-sm text-gray-600 hover:text-gray-700 hover:bg-gray-200 rounded">
                        Directores tecnicos
                    </Link>

                    <Link :href="route('paneles.listarArbitros')"
                    class="mt-3 py-2 text-sm text-gray-600 hover:text-gray-700 hover:bg-gray-200 rounded">
                        Arbitros
                    </Link>
                </nav>
            </div>
    
            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="flex justify-between items-center p-6">
                    <div class="flex items-center space-x-4 lg:space-x-0">
                        <button @click="hamburger()"
                            class="text-gray-500 dark:text-gray-300 focus:outline-none lg:hidden">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </header>
    
                <main class="flex-1 overflow-x-hidden overflow-y-auto">
                    <div class="container mx-auto px-6">
                        <slot name="contenido"></slot>
                    </div>
                </main>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Link } from '@inertiajs/inertia-vue3';

    export default {

        components: {
            AppLayout,
            Link,
        },

        data() {
            return {
                sidebarOpen: false,
            }
        },

        methods: {
            hamburger() {
                this.sidebarOpen = true;
            }
        },
    }
</script>
