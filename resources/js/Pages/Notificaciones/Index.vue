<template>
    <app-layout title="Notificaciones">
        <estructura-notificacion :notificacion_id='notificacion.id'
            v-for="notificacion in notificaciones" :key="notificacion.id">
            <template #notificacion>
                <span v-if="notificacion.type == 'App\\Notifications\\Postulaciones\\PostulacionActualizada' ">
                    Su postulacion tiene como estado actual "{{ notificacion.data.postulacion.estado }}"" para el
                    <Link :href="route('partidos.show', notificacion.data.postulacion.partido.slug)" 
                        class="underline">
                        {{ notificacion.data.postulacion.partido.nombre }}
                    </Link>
                </span>

                <span v-if="notificacion.type == 'App\\Notifications\\Postulaciones\\PostulacionEliminada' ">
                    Su postulacion ha sido eliminada para el partido 
                    "<Link :href="route('partidos.show', notificacion.data.partido.slug)" 
                        class="underline">
                        {{ notificacion.data.partido.nombre }}
                    </Link>" porque el organizador ha finalizado su búsqueda
                </span>
            </template>
        </estructura-notificacion>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraNotificacion from '@/Shared/Notificaciones/EstructuraNotificacion.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraNotificacion,
            Link,
        },

        props: {
            notificaciones: Array,
        },
    })
</script>
