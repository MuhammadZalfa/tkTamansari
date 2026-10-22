<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { Toaster } from '@/components/ui/sonner';

defineProps<{
    title?: string;
}>();

const page = usePage();
const currentUrl = computed(() => page.url);
const userName = computed(() => (page.props.auth as { user?: { name?: string } })?.user?.name ?? 'Admin');
const initial = computed(() => userName.value.charAt(0).toUpperCase());
const mobileOpen = ref(false);

const navItems = [
    { name: 'Dashboard', href: '/admin', icon: 'space_dashboard' },
    { name: 'Profil Sekolah', href: '/admin/profil', icon: 'account_balance' },
    { name: 'Program & Kegiatan', href: '/admin/program', icon: 'event_available' },
    { name: 'Agenda Tahunan', href: '/admin/agenda', icon: 'calendar_month' },
    { name: 'Berita', href: '/admin/berita', icon: 'campaign' },
    { name: 'Galeri', href: '/admin/galeri', icon: 'photo_library' },
    { name: 'Guru & Tendik', href: '/admin/guru', icon: 'groups' },
    { name: 'Kontak', href: '/admin/kontak', icon: 'contact_phone' },
    { name: 'Pesan Masuk', href: '/admin/pesan', icon: 'mark_email_unread' },
];

const isActive = (href: string): boolean => {
    if (href === '/admin') {
        return currentUrl.value === '/admin' || currentUrl.value === '/dashboard';
    }

    return currentUrl.value === href || currentUrl.value.startsWith(`${href}/`);
};

watch(
    () => page.url,
    () => {
        mobileOpen.value = false;
    },
);
</script>

<template>
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-900 flex">
        <div
            v-if="mobileOpen"
            class="fixed inset-0 bg-black/40 z-40 md:hidden"
            aria-hidden="true"
            @click="mobileOpen = false"
        ></div>

        <aside
            :class="[
                'fixed left-0 top-0 h-screen w-72 bg-[#13211C] z-50 flex flex-col justify-between shadow-xl text-white transition-transform duration-200 md:translate-x-0',
                mobileOpen ? 'translate-x-0' : '-translate-x-full',
            ]"
        >
            <div class="flex flex-col overflow-y-auto">
                <div class="flex items-center gap-3 px-6 py-6 border-b border-white/5">
                    <div class="w-10 h-10 rounded-xl bg-[#006738] flex items-center justify-center text-white shadow-md">
                        <span class="material-symbols-outlined text-[24px]">school</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold tracking-tight text-white leading-tight">Admin Portal</span>
                        <span class="text-xs text-gray-400 font-medium">TK PGRI Tamansari</span>
                    </div>
                </div>

                <div class="mx-5 my-5 p-3 rounded-2xl bg-[#1C2E27] flex items-center gap-3 border border-white/5">
                    <span class="w-9 h-9 rounded-full bg-[#006738] text-white flex items-center justify-center text-sm font-bold ring-2 ring-emerald-500/40">
                        {{ initial }}
                    </span>
                    <div class="flex flex-col min-w-0 flex-1">
                        <span class="text-xs font-bold text-white truncate">{{ userName }}</span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs text-emerald-400">Administrator</span>
                            <span class="w-1 h-1 rounded-full bg-gray-500"></span>
                            <span class="text-xs text-gray-400">Online</span>
                        </div>
                    </div>
                </div>

                <nav class="flex flex-col gap-1 px-3 pb-4">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'flex items-center justify-between px-4 py-2.5 rounded-xl transition-all text-xs font-semibold',
                            isActive(item.href)
                                ? 'bg-[#006738] text-white shadow-md'
                                : 'text-gray-400 hover:bg-[#1C2E27] hover:text-white',
                        ]"
                    >
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">{{ item.icon }}</span>
                            <span>{{ item.name }}</span>
                        </div>
                    </Link>
                </nav>
            </div>

            <div class="p-4 border-t border-white/5">
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-gray-400 hover:bg-rose-500/10 hover:text-rose-400 transition-colors"
                >
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span>Keluar / Logout</span>
                </Link>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-screen md:pl-72">
            <header class="h-16 bg-white/95 backdrop-blur-xl border-b border-gray-100 z-30 sticky top-0 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-600 hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500"
                        aria-label="Buka menu navigasi"
                        :aria-expanded="mobileOpen"
                        @click="mobileOpen = !mobileOpen"
                    >
                        <span class="material-symbols-outlined">{{ mobileOpen ? 'close' : 'menu' }}</span>
                    </button>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900 leading-tight">{{ title ?? 'Panel Kendali CMS' }}</span>
                        <span class="text-xs text-gray-500">Portal Kelola Website Resmi TK PGRI Tamansari</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <Link
                        href="/"
                        target="_blank"
                        class="hidden sm:flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-50 text-[#006738] hover:bg-[#006738] hover:text-white transition-colors text-xs font-bold border border-emerald-200"
                    >
                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                        <span>Lihat Web Publik</span>
                    </Link>

                    <div class="flex items-center gap-2 pl-2 border-l border-gray-100">
                        <span class="w-8 h-8 rounded-full bg-[#006738] text-white flex items-center justify-center text-xs font-bold">
                            {{ initial }}
                        </span>
                        <span class="text-xs font-semibold text-gray-700 hidden sm:inline">{{ userName }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-[1600px] w-full mx-auto">
                <slot />
            </main>
        </div>
        <Toaster position="top-right" />
    </div>
</template>
