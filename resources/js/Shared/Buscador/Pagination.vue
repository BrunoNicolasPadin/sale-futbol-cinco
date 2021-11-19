<template>
    <div class="flex flex-wrap my-3">
        <div v-for="(link, index, key) in equiposFiltrados.links" :key="key">
            <button @click="otraPagina(link.label)" 
            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-black rounded hover:bg-white" 
            :class="{ 'bg-white': link.active }" v-html="link.label" />
        </div>
    </div>
</template>