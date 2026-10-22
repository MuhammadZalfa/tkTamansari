<script setup lang="ts">
import PublicNavbar from '@/components/PublicNavbar.vue';
import PublicFooter from '@/components/PublicFooter.vue';

defineProps<{
    title?: string;
}>();
</script>

<template>
    <div class="min-h-screen flex flex-col bg-canvas text-ink font-sans antialiased selection:bg-brand-soft selection:text-brand-on-soft">
        <PublicNavbar />
        
        <main class="w-full pt-20 flex-1">
            <slot />
        </main>

        <PublicFooter />
    </div>
</template>
