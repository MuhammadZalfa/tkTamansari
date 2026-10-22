<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { home, kontak, galeri } from '@/routes';
import { show as beritaShow } from '@/routes/berita';

type BeritaItem = {
    slug: string;
    title: string;
    category: string;
    excerpt: string;
    image_url: string | null;
    image_alt: string | null;
    date_label: string | null;
};

defineProps<{ berita: BeritaItem[] }>();
</script>

<template>
    <GuestLayout>
        <Head title="Berita dan Artikel | TK PGRI Tamansari" />

        <div class="w-full bg-surface-soft border-b border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-ink-subtle">
                    <Link
                        :href="home.url()"
                        class="flex items-center gap-1 hover:text-brand-ink font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft rounded"
                    >
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">home</span>
                        <span>Beranda</span>
                    </Link>
                    <span aria-hidden="true">/</span>
                    <span class="text-ink font-semibold">Berita dan artikel</span>
                </nav>
            </div>
        </div>

        <section class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-10 pb-8">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight leading-tight">
                Berita dan <span class="text-brand-ink underline decoration-sun decoration-wavy decoration-2">Artikel</span>
            </h1>
            <p class="mt-3 max-w-2xl text-sm sm:text-base text-ink-muted leading-relaxed">
                Catatan kegiatan, karya anak, dan perayaan yang mewarnai hari-hari belajar di TK PGRI Tamansari.
            </p>
        </section>

        <section class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pb-14 lg:pb-20">
            <div v-if="berita.length === 0" class="max-w-4xl rounded-2xl bg-surface border border-line p-10 text-center text-sm text-ink-muted">
                Belum ada berita yang diterbitkan.
            </div>

            <div v-else class="flex flex-col gap-6 max-w-4xl">
                <article
                    v-for="artikel in berita"
                    :key="artikel.slug"
                    class="bg-surface rounded-2xl border border-line overflow-hidden flex flex-col sm:flex-row"
                >
                    <Link
                        :href="beritaShow.url(artikel.slug)"
                        class="sm:w-64 shrink-0 block focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                    >
                        <span class="block aspect-[16/10] w-full overflow-hidden bg-surface-soft">
                            <img
                                v-if="artikel.image_url"
                                class="w-full h-full object-cover"
                                :alt="artikel.image_alt ?? artikel.title"
                                :src="artikel.image_url"
                                loading="lazy"
                            />
                        </span>
                    </Link>

                    <div class="p-6 flex flex-col gap-3 flex-1">
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-brand-soft text-brand-on-soft font-bold">
                                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">label</span>
                                {{ artikel.category }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-ink-subtle">
                                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">calendar_today</span>
                                {{ artikel.date_label }}
                            </span>
                        </div>

                        <h2 class="text-lg sm:text-xl font-extrabold text-ink leading-snug">
                            <Link
                                :href="beritaShow.url(artikel.slug)"
                                class="hover:text-brand-ink transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface rounded"
                            >
                                {{ artikel.title }}
                            </Link>
                        </h2>

                        <p class="text-sm text-ink-muted leading-relaxed">{{ artikel.excerpt }}</p>

                        <Link
                            :href="beritaShow.url(artikel.slug)"
                            class="inline-flex items-center gap-1.5 min-h-11 w-fit text-sm font-bold text-brand-ink hover:text-brand transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface rounded"
                        >
                            <span>Baca selengkapnya</span>
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                        </Link>
                    </div>
                </article>
            </div>

            <div class="mt-10 rounded-2xl bg-brand-soft border border-line p-8 sm:p-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-ink">Ingin melihat kegiatan anak secara langsung?</h2>
                    <p class="text-sm text-ink-muted mt-1 max-w-xl">
                        Jadwalkan kunjungan ke sekolah atau jelajahi dokumentasi kegiatan di galeri.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <Link
                        :href="kontak.url()"
                        class="min-h-11 px-5 rounded-xl bg-brand text-on-brand text-sm font-bold inline-flex items-center justify-center gap-2 hover:bg-brand-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-brand-soft"
                    >
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">event_available</span>
                        <span>Jadwalkan kunjungan</span>
                    </Link>
                    <Link
                        :href="galeri.url()"
                        class="min-h-11 px-5 rounded-xl bg-surface border border-line text-sm font-bold text-ink inline-flex items-center justify-center gap-2 hover:bg-surface-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-brand-soft"
                    >
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">photo_library</span>
                        <span>Lihat galeri</span>
                    </Link>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
