<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 40 40"
        :class="className"
        fill="currentColor"
        v-bind="$attrs"
    >
        <!-- School Graduation Cap & Knowledge Emblem -->
        <path d="M20 6L36 14L20 22L4 14L20 6Z" fill="currentColor" />
        <path d="M10 17.5V26C10 30 14.5 33 20 33C25.5 33 30 30 30 26V17.5L20 22.5L10 17.5Z" fill="currentColor" fill-opacity="0.85" />
        <circle cx="20" cy="27" r="2" fill="currentColor" />
        <path d="M33 16V27C33 28.5 31.8 29.5 30.5 29.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none" />
    </svg>
</template>
