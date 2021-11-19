<template>
    <app-layout>
        <div>
            <h1 class="text-2xl font-bold">Partidos para esta semana</h1>
            <h2>Todos los partidos de esta semana para que los puedas agendar</h2>
        </div>

        <div class="my-3 border border-green-300 grid grid-cols-1 md:grid-cols-2 bg-green-300 rounded-md shadow-md">
            <img class="w-full"
            src="https://www.apurogol.net/wp-content/uploads/2020/02/newells-vs-estudiantes-en-vivo-online-superliga-2019-2020-en-directo-fecha-19.png" 
            alt="Portada de la noticia">

            <div class="p-5">
                <h1 class="text-4xl font-bold text-green-900">Mbappe tiene todo acordado para venir a Newell's</h1>

                <p class="leading-7 text-green-800 mt-4 font-semibold">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quod at ullam saepe inventore, sequi vero culpa eius ipsa quisquam hic architecto dolores eum beatae animi veniam facilis reprehenderit harum minus.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-2 gap-y-3 my-4">
            <div class="grid grid-cols-1 border border-green-300 bg-green-300 rounded-md shadow-md">
                <img class="w-full"
                src="https://www.apurogol.net/wp-content/uploads/2020/02/newells-vs-estudiantes-en-vivo-online-superliga-2019-2020-en-directo-fecha-19.png" 
                alt="Portada de la noticia">

                <h1 class="p-2 text-xl font-bold text-green-900">Mbappe tiene todo acordado para venir a Newell's</h1>
            </div>

            <div class="grid grid-cols-1 border border-green-300 bg-green-300 rounded-md shadow-md">
                <img class="w-full"
                src="https://www.apurogol.net/wp-content/uploads/2020/02/newells-vs-estudiantes-en-vivo-online-superliga-2019-2020-en-directo-fecha-19.png" 
                alt="Portada de la noticia">

                <h1 class="p-2 text-xl font-bold text-green-900">Mbappe tiene todo acordado para venir a Newell's</h1>
            </div>

            <div class="grid grid-cols-1 border border-green-300 bg-green-300 rounded-md shadow-md">
                <img class="w-full"
                src="https://www.apurogol.net/wp-content/uploads/2020/02/newells-vs-estudiantes-en-vivo-online-superliga-2019-2020-en-directo-fecha-19.png" 
                alt="Portada de la noticia">

                <h1 class="p-2 text-xl font-bold text-green-900">Mbappe tiene todo acordado para venir a Newell's</h1>
            </div>

            <div class="grid grid-cols-1 border border-green-300 bg-green-300 rounded-md shadow-md">
                <img class="w-full"
                src="https://www.apurogol.net/wp-content/uploads/2020/02/newells-vs-estudiantes-en-vivo-online-superliga-2019-2020-en-directo-fecha-19.png" 
                alt="Portada de la noticia">

                <h1 class="p-2 text-xl font-bold text-green-900">Mbappe tiene todo acordado para venir a Newell's</h1>
            </div>
        </div>

        <hr class="bg-green-600 p-px mt-4">

        <div class="my-4">
            <h1 class="text-2xl font-bold text-left">Contacto</h1>

            <form method="post" @submit.prevent="submit">
                <estructura-formulario>
                    <template #estructuraInput>
                        <estructura-input nombreLabel="Email" info="Es obligatorio.">
                            <template #inputComponente>
                                <input-componente type="text" id="Email" v-model="form.email" />
                            </template>
                        </estructura-input>
                    </template>
                </estructura-formulario>

                <estructura-formulario>
                    <template #estructuraInput>
                        <estructura-input nombreLabel="Motivo" info="Es obligatorio.">
                            <template #inputComponente>
                                <select 
                                required
                                id="Motivo"
                                v-model="form.asunto"
                                class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded">
                                    <option disabled value="">-</option>
                                    <option value="Problema">Tengo un problema</option>
                                    <option value="Error">Encontré un error</option>
                                    <option value="Nuevo evento">Quiero agregar un evento</option>
                                    <option value="Nuevo lugar">Quiero agregar un lugar</option>
                                    <option value="Tengo una pregunta">Tengo una pregunta</option>
                                    <option value="Nueva idea">Tengo una idea para el sitio</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </template>
                        </estructura-input>
                    </template>
                </estructura-formulario>

                <estructura-formulario>
                    <template #estructuraInput>
                        <estructura-input nombreLabel="Mensaje" info="Es obligatorio.">
                            <template #inputComponente>
                                <textarea
                                required
                                id="Mensaje"
                                class="appearance-none outline-none w-full text-gray-800"
                                cols="30" 
                                rows="5" v-model="form.mensaje"></textarea>
                            </template>
                        </estructura-input>
                    </template>
                </estructura-formulario>

                <guardar></guardar>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraFormulario from '@/Shared/Formulario/EstructuraFormulario'
    import EstructuraInput from '@/Shared/Formulario/EstructuraInput'
    import InputComponente from '@/Shared/Formulario/InputComponente'
    import Guardar from '@/Shared/Botones/Guardar'

    export default {
        components: {
            AppLayout,
            EstructuraFormulario,
            EstructuraInput,
            InputComponente,
            Guardar,
        },

        data() {
            return {
                form: {
                    email: null,
                    asunto: null,
                    mensaje: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('contacto.enviar_email'), this.form)
            },
        },
    }
</script>
