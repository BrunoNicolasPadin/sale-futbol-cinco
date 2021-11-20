<template>
    <app-layout title="Partido">
        <div class="px-6">
            <h1 class="text-4xl text-center font-extrabold">{{ partido.nombre }}</h1>

            <ul class="list-disc">
                <li class="my-2">Precio: <span class="font-bold text-blue-900">${{ partido.precio }}</span></li>
                <li class="my-2">Lugar: <span class="font-bold text-blue-900">{{ partido.lugar }}</span></li>
                <li class="my-2">Horario: <span class="font-bold text-blue-900">{{ partido.fechaHoraFinalizacion }}</span></li>
                <li class="my-2">Faltan <span class="font-bold text-blue-900">{{ partido.cuantosFaltan }}</span> jugadores</li>
                <li class="my-2"><span class="font-bold text-blue-900">Cancha de {{ partido.tipoDeCancha }}</span></li>
                <li class="my-2">Estado del anuncio: <span class="font-bold text-blue-900">{{ partido.estado }}</span></li>
                <li class="my-2">Detalles: <p class="font-bold text-blue-900 whitespace-pre-line">{{ partido.detalles }}</p></li>
                <li v-if="partido.user_id != user_id" class="my-2">
                    <button type="button" class="px-2.5 py-2.5 rounded-sm shadow-md bg-blue-600 text-white hover:bg-blue-800 hover:shadow-lg">
                        Quiero jugar
                    </button>
                </li>
            </ul>

            <div v-if="partido.user_id == user_id" class="mt-10 flex justify-end">
                <div class="flex space-x-2">
                    <button type="button" @click="editar()" class="px-2.5 py-2.5 rounded-sm shadow-md bg-yellow-400 text-white hover:bg-yellow-500 hover:shadow-lg">
                        Editar
                    </button>

                    <button type="button" @click="eliminar()" class="px-2.5 py-2.5 rounded-sm shadow-md bg-red-400 text-white hover:bg-red-500 hover:shadow-lg">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
            components: {
            AppLayout,
            Link,
        },

        props: {
            partido: Object,
            user_id: String,
        },

        methods: {
            editar() {
                this.$inertia.get(this.route('partidos.edit', this.partido.slug))
            },

            eliminar() {
                if (confirm('¿Estás seguro de que deseas eliminar este partido?')) {
                    this.$inertia.delete(this.route('partidos.destroy', this.partido.slug));
                }
            }
        }
    })
</script>