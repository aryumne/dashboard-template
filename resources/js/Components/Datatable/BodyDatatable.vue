<template>
    <div class="overflow-scroll mb-4">
        <table class="relative items-center w-full bg-transparent border-collapse">
            <thead class="relative z-10 sticky top-0">
                <slot name="thead" />
            </thead>
            <tbody class="bg-transparent">
                <slot name="tbody" />
            </tbody>
        </table>
    </div>
</template>
