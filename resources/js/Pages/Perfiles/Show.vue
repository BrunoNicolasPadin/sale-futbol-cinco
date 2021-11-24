<template>
    <app-layout title="Perfil">
        <perfil-nav-componente :usuario="usuario" />

        <resumen-titulo titulo='Celular' :valor='usuario.numero' />

        <resumen-titulo titulo='Calificación como organizador' :valor='calificacionOrganizador[0]' />

        <resumen-titulo titulo='Cantidad de votos recibidos como organizador' :valor='calificacionOrganizador[1]' />

        <resumen-titulo titulo='Calificación como jugador' :valor='calificacionJugador[0]' />

        <resumen-titulo titulo='Cantidad de votos recibidos como jugador' :valor='calificacionJugador[1]' />
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import PerfilNavComponente from '@/Shared/Perfil/PerfilNavComponente.vue';
    import ResumenTitulo from '@/Shared/Perfil/ResumenTitulo.vue';

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            PerfilNavComponente,
            ResumenTitulo,
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
