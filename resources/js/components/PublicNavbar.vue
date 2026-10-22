<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed, watch, nextTick, onMounted, onBeforeUnmount } from 'vue';
import { home, profil, program, galeri, kontak, login } from '@/routes';
import { index as beritaIndex } from '@/routes/berita';

const page = usePage();
const mobileMenuOpen = ref(false);
const menuButton = ref<HTMLButtonElement | null>(null);
const menuPanel = ref<HTMLElement | null>(null);

const navItems = [
    { name: 'Beranda', href: home.url() },
    { name: 'Profil Sekolah', href: profil.url() },
    { name: 'Program dan Kegiatan', href: program.url() },
    { name: 'Berita dan Artikel', href: beritaIndex.url() },
    { name: 'Galeri Foto', href: galeri.url() },
    { name: 'Kontak Kami', href: kontak.url() },
];

const currentUrl = computed(() => page.url);

const isActive = (href: string) => {
    if (href === '/') {
        return currentUrl.value === '/' || currentUrl.value === '';
    }
    return currentUrl.value.startsWith(href);
};

const closeMenu = () => {
    if (!mobileMenuOpen.value) {
        return;
    }

    mobileMenuOpen.value = false;
    nextTick(() => menuButton.value?.focus());
};

const handleKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Escape') {
        closeMenu();
    }
};

const handleOutsideClick = (event: MouseEvent) => {
    if (!mobileMenuOpen.value) {
        return;
    }

    const target = event.target as Node;

    if (menuPanel.value?.contains(target) || menuButton.value?.contains(target)) {
        return;
    }

    mobileMenuOpen.value = false;
};

watch(() => page.url, closeMenu);

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);
    document.addEventListener('click', handleOutsideClick);
});

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handleKeydown);
    document.removeEventListener('click', handleOutsideClick);
});
</script>

<template>
    <header class="fixed top-0 left-0 right-0 z-50 bg-surface/95 backdrop-blur-md border-b border-line">
        <div class="h-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
            <!-- Brand -->
            <Link
                 :href="home.url()"
                class="flex items-center gap-3 shrink-0 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            >
                <span class="w-11 h-11 rounded-full bg-brand-soft text-brand-ink flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]" aria-hidden="true">school</span>
                </span>
                <span class="flex flex-col leading-tight">
                    <span class="font-extrabold text-base sm:text-lg text-ink">TK PGRI Tamansari</span>
                    <span class="text-xs sm:text-xs text-ink-subtle">Taman Kanak-kanak, Tasikmalaya</span>
                </span>
            </Link>

            <!-- Desktop Navigation -->
            <nav aria-label="Navigasi utama" class="hidden xl:flex items-center gap-1">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    :aria-current="isActive(item.href) ? 'page' : undefined"
                    :class="[
                        'inline-flex items-center h-11 px-3 rounded-lg text-sm font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
                        isActive(item.href)
                            ? 'bg-brand-soft text-brand-on-soft'
                            : 'text-ink-muted hover:text-brand-ink hover:bg-surface-soft',
                    ]"
                >
                    {{ item.name }}
                </Link>
            </nav>

            <!-- Desktop Actions -->
            <div class="hidden xl:flex items-center gap-2">
                <Link
                     :href="login.url()"
                    class="inline-flex items-center h-11 px-3 rounded-lg text-sm font-semibold text-ink-muted hover:text-brand-ink hover:bg-surface-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                >
                    Portal Guru
                </Link>
                <Link
                    :href="kontak.url()"
                    class="inline-flex items-center h-11 px-4 rounded-xl bg-brand text-on-brand text-sm font-bold hover:bg-brand-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                >
                    Jadwalkan Kunjungan
                </Link>
            </div>

            <!-- Mobile Toggle -->
            <button
                ref="menuButton"
                type="button"
                class="xl:hidden inline-flex items-center justify-center w-11 h-11 rounded-xl border border-line text-ink transition-colors hover:bg-surface-soft focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                :aria-expanded="mobileMenuOpen"
                aria-controls="menu-mobile"
                :aria-label="mobileMenuOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi'"
                @click="mobileMenuOpen = !mobileMenuOpen"
            >
                <span class="material-symbols-outlined text-[24px]" aria-hidden="true">
                    {{ mobileMenuOpen ? 'close' : 'menu' }}
                </span>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div
            v-show="mobileMenuOpen"
            id="menu-mobile"
            ref="menuPanel"
            class="xl:hidden border-t border-line bg-surface"
        >
            <nav aria-label="Navigasi utama seluler" class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex flex-col">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    :aria-current="isActive(item.href) ? 'page' : undefined"
                    :class="[
                        'inline-flex items-center min-h-11 px-3 rounded-lg text-sm font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
                        isActive(item.href)
                            ? 'bg-brand-soft text-brand-on-soft'
                            : 'text-ink-muted hover:text-brand-ink hover:bg-surface-soft',
                    ]"
                >
                    {{ item.name }}
                </Link>

                <div class="flex flex-col sm:flex-row gap-2 mt-3 pt-3 border-t border-line">
                    <Link
                        :href="kontak.url()"
                        class="inline-flex items-center justify-center min-h-11 px-4 rounded-xl bg-brand text-on-brand text-sm font-bold hover:bg-brand-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                    >
                        Jadwalkan Kunjungan
                    </Link>
                    <Link
                         :href="login.url()"
                        class="inline-flex items-center justify-center min-h-11 px-4 rounded-xl border border-line-strong text-sm font-semibold text-ink hover:bg-surface-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                    >
                        Portal Guru
                    </Link>
                </div>
            </nav>
        </div>
    </header>
</template>
