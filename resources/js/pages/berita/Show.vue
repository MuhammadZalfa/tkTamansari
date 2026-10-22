<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { home, kontak, program, galeri } from '@/routes';
import { index as beritaIndex } from '@/routes/berita';

type BeritaMoment = {
    title: string;
    note: string | null;
    image_url: string | null;
};

type BeritaDetail = {
    slug: string;
    title: string;
    category: string;
    excerpt: string;
    body: string;
    image_url: string | null;
    image_alt: string | null;
    image_caption: string | null;
    quote: string | null;
    quote_attribution: string | null;
    date_label: string | null;
    tags: string[] | null;
    moments: BeritaMoment[];
};

const props = defineProps<{ berita: BeritaDetail }>();

const page = usePage();
const kontakInfo = computed(() => (page.props.kontak ?? {}) as Record<string, any>);

const article = computed(() => props.berita);
const paragraphs = computed(() => props.berita.body.split(/\n\s*\n/).filter(Boolean));

const copied = ref(false);

function shareUrl(): string {
    return typeof window === 'undefined' ? '' : window.location.href;
}

function shareWA(): void {
    if (typeof window === 'undefined') {
        return;
    }

    const text = encodeURIComponent((article.value?.title ?? 'Berita sekolah') + ' di TK PGRI Tamansari: ' + shareUrl());

    window.open(`https://api.whatsapp.com/send?text=${text}`, '_blank', 'noopener');
}

function shareFB(): void {
    if (typeof window === 'undefined') {
        return;
    }

    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl())}`, '_blank', 'noopener');
}

function copyLink(): void {
    if (typeof navigator === 'undefined' || !navigator.clipboard) {
        return;
    }

    navigator.clipboard.writeText(shareUrl());
    copied.value = true;

    setTimeout(() => {
        copied.value = false;
    }, 2000);
}

const jelajahi = [
    { label: 'Program dan kegiatan', description: 'Jenjang KB, TK-A, TK-B, dan agenda tahunan.', href: program.url(), icon: 'auto_stories' },
    { label: 'Galeri dokumentasi', description: 'Rekaman kegiatan belajar dan kreativitas anak.', href: galeri.url(), icon: 'photo_library' },
    { label: 'Kontak dan kunjungan', description: 'Sesi kelas percobaan dan jadwal kunjungan.', href: kontak.url(), icon: 'event_available' },
    { label: 'Beranda sekolah', description: 'Profil singkat dan layanan utama sekolah.', href: home.url(), icon: 'home' },
];
</script>

<template>
    <GuestLayout>
        <Head :title="`${article?.title ?? 'Berita sekolah'} | TK PGRI Tamansari`" />

        <div class="w-full bg-surface-soft border-b border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-ink-subtle overflow-x-auto whitespace-nowrap">
                    <Link
                        :href="home.url()"
                        class="flex items-center gap-1 hover:text-brand-ink font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft rounded"
                    >
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">home</span>
                        <span>Beranda</span>
                    </Link>
                    <span aria-hidden="true">/</span>
                    <Link
                        :href="beritaIndex.url()"
                        class="hover:text-brand-ink font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft rounded"
                    >
                        Berita dan artikel
                    </Link>
                    <span aria-hidden="true">/</span>
                    <span class="text-ink font-semibold truncate max-w-xs md:max-w-md">{{ article?.title }}</span>
                </nav>
            </div>
        </div>

        <div v-if="article" class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                <article class="lg:col-span-8 flex flex-col gap-6">
                    <div class="bg-surface rounded-2xl border border-line p-6 sm:p-8 lg:p-10 flex flex-col gap-6">
                        <header class="flex flex-col gap-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-brand-soft text-brand-on-soft text-xs font-bold">
                                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">label</span>
                                    {{ article.category }}
                                </span>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-sun-soft text-sun-ink text-xs font-medium">
                                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">calendar_today</span>
                                    {{ article.date_label }}
                                </span>
                            </div>

                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-ink tracking-tight leading-tight">
                                {{ article.title }}
                            </h1>

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-3 border-y border-line">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-10 h-10 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">campaign</span>
                                    </span>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-ink">Dokumentasi sekolah</span>
                                        <span class="text-xs text-ink-muted">{{ article.date_label }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        @click="shareWA"
                                        class="inline-flex items-center gap-1.5 min-h-11 px-3.5 rounded-xl bg-brand-soft text-brand-on-soft hover:bg-brand hover:text-on-brand text-xs font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                                    >
                                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">chat</span>
                                        <span>WhatsApp</span>
                                    </button>
                                    <button
                                        type="button"
                                        @click="shareFB"
                                        class="inline-flex items-center gap-1.5 min-h-11 px-3.5 rounded-xl bg-sky-soft text-sky hover:bg-sky hover:text-on-brand text-xs font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                                    >
                                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">public</span>
                                        <span>Facebook</span>
                                    </button>
                                    <button
                                        type="button"
                                        @click="copyLink"
                                        class="inline-flex items-center gap-1.5 min-h-11 px-3.5 rounded-xl bg-surface-soft text-ink-muted hover:bg-brand-soft hover:text-brand-on-soft text-xs font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                                    >
                                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">link</span>
                                        <span aria-live="polite">{{ copied ? 'Tersalin' : 'Salin' }}</span>
                                    </button>
                                </div>
                            </div>
                        </header>

                        <figure class="m-0 overflow-hidden rounded-2xl border border-line bg-surface-soft">
                            <div class="relative w-full aspect-[16/9] overflow-hidden">
                                <img
                                    class="w-full h-full object-cover"
                                     :alt="article.image_alt ?? article.title"
                                     :src="article.image_url ?? ''"
                                />
                                <span class="absolute bottom-3 left-3 bg-black/65 text-white px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-sun" aria-hidden="true">photo_camera</span>{{ article.category }}</span>
                            </div>
                            <figcaption class="px-4 py-3 text-xs text-ink-subtle bg-surface-soft flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-ink text-[18px]" aria-hidden="true">collections</span>
                                <span>{{ article.image_caption }}</span>
                            </figcaption>
                        </figure>

                        <div class="flex flex-col gap-4 text-sm sm:text-base text-ink-muted leading-relaxed">
                            <template v-for="(paragraf, index) in paragraphs" :key="index">
                                <p :class="index === 0 ? 'text-base sm:text-lg text-ink' : ''">
                                    {{ paragraf }}
                                </p>
                                <figure
                                    v-if="index === 1"
                                    class="m-0 p-5 sm:p-6 rounded-2xl bg-brand-soft border border-line"
                                >
                                    <blockquote class="text-base sm:text-lg text-brand-on-soft font-bold leading-snug">
                                        "{{ article.quote }}"
                                    </blockquote>
                                    <figcaption class="flex items-center gap-2 pt-3 text-xs font-semibold text-ink-muted">
                                        <span class="h-0.5 w-6 bg-sun rounded-full" aria-hidden="true"></span>
                                        {{ article.quote_attribution }}
                                    </figcaption>
                                </figure>
                            </template>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h3 class="text-base font-bold text-ink flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-ink text-[20px]" aria-hidden="true">photo_library</span>
                                <span>Galeri momen peringatan</span>
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <figure
                                    v-for="momen in article.moments"
                                    :key="momen.title"
                                    class="m-0 overflow-hidden rounded-xl border border-line bg-surface-soft"
                                >
                                    <div class="aspect-[4/3] w-full overflow-hidden">
                                        <img class="w-full h-full object-cover" :alt="momen.title" :src="momen.image_url ?? ''" />
                                    </div>
                                    <figcaption class="p-3">
                                        <p class="text-xs font-bold text-ink leading-snug">{{ momen.title }}</p>
                                        <span class="text-xs text-ink-subtle">{{ momen.note }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-line flex flex-wrap items-center gap-2">
                            <span class="text-xs font-bold text-ink-muted flex items-center gap-1 mr-1">
                                <span class="material-symbols-outlined text-[16px] text-brand-ink" aria-hidden="true">tag</span>
                                Tag
                            </span>
                            <span
                                v-for="tag in article.tags ?? []"
                                :key="tag"
                                class="px-3 py-1 rounded-xl bg-surface-soft text-xs text-ink-muted"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </article>

                <aside class="lg:col-span-4 flex flex-col gap-6">
                    <Link
                        :href="beritaIndex.url()"
                        class="w-full min-h-11 px-4 rounded-xl bg-surface text-brand-ink text-sm font-bold flex items-center justify-center gap-2 border border-line hover:bg-brand-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas"
                    >
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">arrow_back</span>
                        <span>Kembali ke berita dan artikel</span>
                    </Link>

                    <nav aria-label="Halaman sekolah lainnya" class="bg-surface rounded-2xl border border-line p-6 flex flex-col gap-4">
                        <h2 class="text-sm font-bold text-ink flex items-center gap-2 pb-3 border-b border-line">
                            <span class="material-symbols-outlined text-sun-ink text-[20px]" aria-hidden="true">explore</span>
                            <span>Jelajahi sekolah</span>
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li v-for="item in jelajahi" :key="item.label">
                                <Link
                                    :href="item.href"
                                    class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-surface-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                                >
                                    <span class="w-9 h-9 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">{{ item.icon }}</span>
                                    </span>
                                    <span class="flex flex-col">
                                        <span class="text-xs font-bold text-ink">{{ item.label }}</span>
                                        <span class="text-xs text-ink-muted">{{ item.description }}</span>
                                    </span>
                                </Link>
                            </li>
                        </ul>
                    </nav>

                    <div class="rounded-2xl bg-brand text-on-brand p-6 flex flex-col gap-4">
                        <span class="w-12 h-12 rounded-xl bg-black/30 flex items-center justify-center text-sun">
                            <span class="material-symbols-outlined text-[28px]" aria-hidden="true">volunteer_activism</span>
                        </span>
                        <div>
                            <h2 class="text-base font-bold leading-tight">Ingin mengenal sekolah lebih dekat?</h2>
                            <p class="text-xs mt-1 leading-relaxed">
                                Kunjungi lingkungan ramah anak kami atau jadwalkan sesi kelas percobaan untuk buah hati Anda.
                            </p>
                        </div>
                        <a
                            :href="kontakInfo.whatsapp_link"
                            target="_blank"
                            rel="noopener"
                            class="w-full min-h-11 px-4 rounded-xl bg-sun text-on-sun font-bold text-xs flex items-center justify-center gap-2 hover:bg-sun-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-brand"
                        >
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">chat</span>
                            <span>Jadwalkan Kunjungan via WhatsApp</span>
                        </a>
                    </div>
                </aside>
            </div>
        </div>

        <div v-else class="max-w-2xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="bg-surface rounded-2xl border border-line p-8 sm:p-10 flex flex-col items-center text-center gap-4">
                <span class="w-12 h-12 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]" aria-hidden="true">article</span>
                </span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-ink">Artikel tidak ditemukan</h1>
                <p class="text-sm text-ink-muted max-w-md">
                    Artikel yang Anda cari sudah dipindahkan atau tidak pernah dipublikasikan. Lihat daftar berita terbaru sekolah.
                </p>
                <Link
                    :href="beritaIndex.url()"
                    class="min-h-11 px-5 rounded-xl bg-brand text-on-brand text-sm font-bold inline-flex items-center justify-center gap-2 hover:bg-brand-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas"
                >
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">arrow_back</span>
                    <span>Lihat semua berita</span>
                </Link>
            </div>
        </div>
    </GuestLayout>
</template>
