<template>
    <div class="flex justify-center my-12 sm:my-0">
        <div class="w-full px-6 py-3 shadow-lg rounded-lg flex flex-col items-center
                sm:m-4 sm:flex-row bg-blue-800 border border-blue-800 text-white">
            <div class="w-10/12">
                <slot name="notificacion"></slot>
            </div>
            <div class="w-2/12 mt-2 sm:mt-0 sm:ml-4 justify-end">
                <button @click="marcarComoLeido()" class="px-3 py-2 hover:bg-blue-900 hover:border border-white transition ease-in-out duration-300"> Marcar como leida </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            notificacion_id: String,
        },

        methods: {
            marcarComoLeido() {
                axios.get(this.route('notificaciones.marcarComoLeida', this.notificacion_id))
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },
        }
    }
</script>