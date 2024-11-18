<script setup>
defineProps({
    sectionClass: String,
    containerClass: String,
});
</script>

<template>
    <section :class="sectionClass">
        <div class="mx-auto px-3" :class="containerClass">
            <slot />
        </div>
    </section>
</template>
