<template>
    <div class="text-center overflow-x-auto overflow-y-auto relative h-auto my-6">
        <table class="border-collapse table-auto w-full whitespace-no-wrap table-striped relative">
            <slot name="head"></slot>
            <tbody>
                <slot name="tr"></slot>
            </tbody>
        </table>
    </div>
</template>