<template>
    <app-layout title="Perfil">
        <perfil-nav-componente :usuario="usuario" />

        <h1 class="text-2xl my-3"><span class="font-bold">Celular</span>: {{ usuario.numero }}</h1>

        <hr class="bg-gray-300 p-px my-3">

        <h1 class="text-2xl my-3"><span class="font-bold">Calificación como organizador</span>: {{ calificacionOrganizador[0] }}/10</h1>
        <h1 class="text-2xl my-3"><span class="font-bold">Votos</span>: {{ calificacionOrganizador[1] }}</h1>

        <hr class="bg-gray-300 p-px my-3">

        <h1 class="text-2xl my-3"><span class="font-bold">Calificación como jugador</span>: {{ calificacionJugador[0] }}/10</h1>
        <h1 class="text-2xl my-3"><span class="font-bold">Votos</span>: {{ calificacionJugador[1] }}</h1>

        <hr class="bg-gray-300 p-px my-3">
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import PerfilNavComponente from '@/Shared/Perfil/PerfilNavComponente.vue';

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            PerfilNavComponente,
        },

        props: {
            usuario: Object,
            calificacionOrganizador: Array,
            calificacionJugador: Array,
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
