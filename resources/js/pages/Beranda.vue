<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { program, kontak, profil } from '@/routes';
import { index as beritaIndex, show as beritaShow } from '@/routes/berita';

type ProgramItem = {
    id: number;
    name: string;
    short_name: string | null;
    age_range: string | null;
    summary: string | null;
    schedule: string | null;
    time: string | null;
    ratio: string | null;
    image_url: string | null;
};

type BeritaItem = {
    slug: string;
    title: string;
    category: string;
    excerpt: string;
    image_url: string | null;
    date_label: string | null;
};

defineProps<{
    programs: ProgramItem[];
    latestBerita: BeritaItem | null;
}>();

const page = usePage();
const kontakInfo = computed(() => (page.props.kontak ?? {}) as Record<string, any>);

const pillars = [
    {
        icon: 'auto_stories',
        title: 'Kurikulum Holistik',
        body: 'Integrasi nilai karakter, literasi awal, eksplorasi sains kreatif, dan cinta pada seni budaya Sunda sejak dini.',
        note: 'Pembelajaran tematik aktif',
    },
    {
        icon: 'volunteer_activism',
        title: 'Pendidik Berhati Pengasih',
        body: 'Pendidik berlatar PG-PAUD yang penyabar, memahami psikologi perkembangan anak, dan mengasuh dengan empati.',
        note: 'Kualifikasi pendidikan PG-PAUD',
    },
    {
        icon: 'park',
        title: 'Fasilitas Asri dan Aman',
        body: 'Ruang kelas bersih dan sejuk, area bermain luar ruangan, pojok baca, serta kebun sains kecil.',
        note: 'Keamanan lingkungan terjaga',
    },
    {
        icon: 'favorite',
        title: 'Adab dan Karakter Mulia',
        body: 'Pembiasaan doa harian, hafalan surat pendek ringan, budaya senyum dan sapa santun, serta pembinaan empati sosial sejak awal.',
        note: 'Pembiasaan akhlakul karimah',
    },
];

</script>

<template>
    <GuestLayout>
        <Head title="Beranda | TK PGRI Tamansari" />

        <div class="flex flex-col w-full">
            <!-- HERO -->
            <section class="w-full bg-canvas pt-10 pb-14 lg:pb-20 border-b border-line">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                        <!-- Pesan dan aksi -->
                        <div class="lg:col-span-7 flex flex-col items-start">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-brand-soft text-brand-on-soft text-xs font-bold mb-6">
                                <span class="material-symbols-outlined text-[18px]" aria-hidden="true">school</span>
                                Pendidikan Anak Usia Dini Ramah Anak
                            </span>

                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight leading-tight mb-6">
                                Tumbuhkan <span class="text-brand-ink underline decoration-sun decoration-wavy decoration-2">Potensi</span> dan Karakter Mulia si Kecil di Lingkungan Penuh Kasih
                            </h1>

                            <p class="text-base sm:text-lg text-ink-muted max-w-2xl mb-8 leading-relaxed">
                                Metode pembelajaran aktif berbasis <strong class="text-ink">Kurikulum Merdeka PAUD</strong> dengan pendekatan bermain yang menyenangkan, lingkungan asri perbukitan Tamansari, dan pendidik berdedikasi membimbing masa emas buah hati Anda.
                            </p>

                            <div class="flex flex-wrap items-center gap-3 mb-10">
                                <Link
                                    :href="kontak.url()"
                                    class="inline-flex items-center justify-center gap-2 min-h-12 px-6 rounded-xl bg-sun text-on-sun font-bold hover:bg-sun-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas"
                                >
                                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">calendar_today</span>
                                    <span>Jadwalkan Kunjungan</span>
                                </Link>
                                <Link
                                    :href="profil.url()"
                                    class="inline-flex items-center justify-center gap-2 min-h-12 px-6 rounded-xl bg-surface text-brand-ink font-bold border border-line-strong hover:bg-surface-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas"
                                >
                                    <span>Kenal Profil Sekolah</span>
                                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">arrow_forward</span>
                                </Link>
                            </div>

                            <!-- Fakta ringkas -->
                            <dl class="pt-6 border-t border-line w-full grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-11 h-11 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[22px]" aria-hidden="true">verified</span>
                                    </span>
                                    <div>
                                        <dt class="text-xs font-bold text-ink">Akreditasi A</dt>
                                        <dd class="text-xs text-ink-subtle">BAN PAUD dan PNF</dd>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="w-11 h-11 rounded-xl bg-sun-soft text-sun-ink flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[22px]" aria-hidden="true">groups</span>
                                    </span>
                                    <div>
                                        <dt class="text-xs font-bold text-ink">Rasio 1 guru : 12 anak</dt>
                                        <dd class="text-xs text-ink-subtle">Perhatian intensif</dd>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="w-11 h-11 rounded-xl bg-sky-soft text-sky flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[22px]" aria-hidden="true">child_care</span>
                                    </span>
                                    <div>
                                        <dt class="text-xs font-bold text-ink">Ramah anak</dt>
                                        <dd class="text-xs text-ink-subtle">Standar sekolah aman</dd>
                                    </div>
                                </div>
                            </dl>
                        </div>

                        <!-- Visual -->
                        <div class="lg:col-span-5">
                            <figure class="m-0">
                                <div class="overflow-hidden rounded-2xl border border-line bg-surface">
                                    <img
                                        class="w-full h-[360px] sm:h-[440px] object-cover object-center"
                                        alt="Suasana ceria di dalam kelas TK PGRI Tamansari"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuALhqT4YvYE0O8p_79byyo2WUT1f6jw-0voW6oZLfmkv4OZccseSoXkQI8yQink404r4Ss5gLv-Rabd4_1RwKRxeLXriWC1QCtHQ45xvL79cF1VItzksEhIvKwk6aQF1VS8u5_wuplQK-5C9k6Z7IUcm7gAoFOa4o-rumBeRqNP4A0Rd3XYtXpyP0tB1oVvSqIK5HyeHvkz7lHX9QfIuCP6-Am-A8DXJcjgr4LB-I5EoQkU6s5lTaoY"
                                    />
                                </div>
                                <figcaption class="mt-3 flex items-center gap-2 text-xs text-ink-muted">
                                    <span class="material-symbols-outlined text-[18px] text-brand-ink" aria-hidden="true">nature_people</span>
                                    Gedung asri dan nyaman, dekat area wisata Tamansari.
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PILAR -->
            <section class="w-full py-14 lg:py-20 bg-canvas">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl mb-10">
                        <span class="block text-xs font-bold uppercase tracking-wider text-brand-ink mb-3">Mengapa memilih kami</span>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-ink tracking-tight mb-4">
                            Pondasi kokoh untuk tumbuh kembang buah hati
                        </h2>
                        <p class="text-base text-ink-muted">
                            Empat pilar utama yang dirancang untuk menghadirkan pengalaman belajar bermakna, membentuk karakter positif, dan menanamkan cinta belajar seumur hidup.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 border border-line rounded-2xl bg-surface divide-y divide-line md:divide-y-0">
                        <div
                            v-for="(pillar, index) in pillars"
                            :key="pillar.title"
                            class="flex flex-col gap-4 p-6 lg:p-8"
                            :class="[
                                index % 2 === 0 ? 'md:border-r md:border-line' : '',
                                index < 2 ? 'md:border-b md:border-line' : '',
                            ]"
                        >
                            <span class="w-12 h-12 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center">
                                <span class="material-symbols-outlined text-[26px]" aria-hidden="true">{{ pillar.icon }}</span>
                            </span>
                            <div class="flex flex-col gap-2">
                                <h3 class="text-lg font-bold text-ink">{{ pillar.title }}</h3>
                                <p class="text-sm text-ink-muted leading-relaxed">{{ pillar.body }}</p>
                            </div>
                            <p class="text-xs font-semibold text-brand-ink flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">check_circle</span>
                                {{ pillar.note }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PROGRAM -->
            <section class="w-full py-14 lg:py-20 bg-surface-soft border-y border-line">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                        <div class="max-w-2xl">
                            <span class="block text-xs font-bold uppercase tracking-wider text-brand-ink mb-3">Kelompok belajar</span>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-ink tracking-tight">
                                Program sesuai tahapan usia emas
                            </h2>
                            <p class="text-base text-ink-muted mt-3">
                                Setiap anak bertumbuh dengan ritmenya masing-masing. Program dibagi menjadi tiga tingkatan terpadu yang memfasilitasi kebutuhan kognitif dan emosional mereka.
                            </p>
                        </div>
                        <Link
                             :href="program.url()"
                            class="inline-flex items-center gap-1.5 self-start text-sm font-bold text-brand-ink hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas rounded"
                        >
                            <span>Lihat program lengkap</span>
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                        </Link>
                    </div>

                    <div v-if="programs.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <article
                            v-for="item in programs"
                            :key="item.id"
                            class="flex flex-col overflow-hidden rounded-2xl bg-surface border border-line"
                        >
                            <div class="relative h-52 overflow-hidden">
                                <img class="w-full h-full object-cover" :alt="item.name" :src="item.image_url ?? ''" />
                                <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full bg-sun text-on-sun text-xs font-bold">
                                    {{ item.age_range }}
                                </span>
                            </div>
                            <div class="flex flex-col flex-1 p-6">
                                <h3 class="text-xl font-bold text-ink mb-2">{{ item.name }}</h3>
                                <p class="text-sm text-ink-muted mb-5 leading-relaxed">{{ item.summary }}</p>
                                <dl class="flex flex-col gap-2 text-xs text-ink-muted mb-6 mt-auto">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-brand-ink text-[18px]" aria-hidden="true">schedule</span>
                                        <dd>{{ item.schedule }} ({{ item.time }})</dd>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-brand-ink text-[18px]" aria-hidden="true">diversity_3</span>
                                        <dd>Rasio guru dan siswa: {{ item.ratio }}</dd>
                                    </div>
                                </dl>
                                <Link
                                     :href="program.url()"
                                    class="inline-flex items-center justify-center gap-2 min-h-11 px-4 rounded-xl border border-line-strong text-sm font-semibold text-brand-ink hover:bg-brand-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                                >
                                    <span>Detail program {{ item.name.split(' ')[0] }}</span>
                                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                                </Link>
                            </div>
                        </article>
                    </div>
                    <p v-else class="rounded-2xl bg-surface border border-line p-8 text-sm text-ink-muted">
                        Program jenjang belum ditambahkan. Silakan hubungi sekolah untuk informasi kelas yang tersedia.
                    </p>
                </div>
            </section>

            <!-- JAM BELAJAR -->
            <section class="w-full py-14 lg:py-20 bg-brand text-on-brand">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
                        <div class="max-w-2xl">
                            <span class="block text-xs font-bold uppercase tracking-wider text-on-brand/80 mb-3">Jam belajar</span>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
                                Jadwal yang jelas untuk keluarga
                            </h2>
                            <p class="text-sm text-on-brand/85 mt-3">
                                Kelas dimulai pada hari kerja. Grup KB berjalan tiga kali seminggu, sedangkan kelompok TK berjalan setiap hari Senin sampai Jumat.
                            </p>
                        </div>
                        <Link
                             :href="kontak.url()"
                            class="inline-flex items-center justify-center gap-2 min-h-11 px-5 rounded-xl bg-sun text-on-sun text-sm font-bold hover:bg-sun-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-brand"
                        >
                            Tanya jadwal kunjungan
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                        </Link>
                    </div>

                    <dl v-if="programs.length > 0" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div
                            v-for="row in programs"
                            :key="row.id"
                            class="rounded-2xl bg-brand-strong/60 border border-on-brand/20 px-5 py-5"
                        >
                            <dt class="text-lg font-extrabold mb-1">{{ row.short_name }}</dt>
                            <dd class="text-sm text-on-brand/85">{{ row.schedule }}</dd>
                            <dd class="text-xl font-extrabold mt-2">{{ row.time }}</dd>
                        </div>
                    </dl>
                    <p v-else class="text-sm text-on-brand/85">
                        Jadwal kelas akan diumumkan oleh sekolah. Hubungi humas untuk informasi terbaru.
                    </p>
                </div>
            </section>

            <!-- KABAR & AJAKAN -->
            <section class="w-full py-14 lg:py-20 bg-canvas">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
                        <div class="max-w-2xl">
                            <span class="block text-xs font-bold uppercase tracking-wider text-brand-ink mb-3">Kabar dan ajakan</span>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-ink tracking-tight">
                                Keseruan aktivitas sekolah
                            </h2>
                        </div>
                        <Link
                             :href="beritaIndex.url()"
                            class="inline-flex items-center gap-1 text-sm font-bold text-brand-ink hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas rounded"
                        >
                            <span>Lihat semua berita</span>
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Artikel -->
                        <article v-if="latestBerita" class="lg:col-span-2 flex flex-col overflow-hidden rounded-2xl bg-surface border border-line">
                            <div class="relative h-56 sm:h-72 overflow-hidden">
                                <img
                                    v-if="latestBerita.image_url"
                                    class="w-full h-full object-cover"
                                    :alt="latestBerita.title"
                                    :src="latestBerita.image_url"
                                />
                                <span class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full bg-brand-soft text-brand-on-soft text-xs font-semibold">
                                    {{ latestBerita.category }}
                                </span>
                            </div>
                            <div class="flex flex-col flex-1 p-6">
                                <p class="flex items-center gap-2 text-xs text-ink-subtle mb-2">
                                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">calendar_month</span>
                                    <span>{{ latestBerita.date_label }}</span>
                                </p>
                                <h3 class="text-xl font-bold text-ink mb-3 leading-snug">
                                    {{ latestBerita.title }}
                                </h3>
                                <p class="text-sm text-ink-muted leading-relaxed mb-6">
                                    {{ latestBerita.excerpt }}
                                </p>
                                <Link
                                    :href="beritaShow.url(latestBerita.slug)"
                                    class="inline-flex items-center gap-1.5 self-start min-h-11 text-sm font-bold text-brand-ink hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface rounded"
                                >
                                    <span>Baca selengkapnya</span>
                                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                                </Link>
                            </div>
                        </article>
                        <div v-else class="lg:col-span-2 flex items-center justify-center rounded-2xl bg-surface border border-line p-10 text-sm text-ink-muted">
                            Belum ada berita yang diterbitkan.
                        </div>

                        <!-- Ajakan -->
                        <div class="flex flex-col gap-6">
                            <article class="flex flex-col flex-1 rounded-2xl bg-surface border border-line p-6">
                                <span class="w-12 h-12 rounded-xl bg-sun-soft text-sun-ink flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-[26px]" aria-hidden="true">how_to_reg</span>
                                </span>
                                <h3 class="text-lg font-bold text-ink mb-2">Sesi kelas percobaan</h3>
                                <p class="text-sm text-ink-muted leading-relaxed mb-5">
                                    Anak dapat mencoba satu atau dua sesi di kelas sebelum orang tua memutuskan mendaftar.
                                </p>
                                <Link
                                     :href="kontak.url()"
                                    class="inline-flex items-center gap-1.5 self-start min-h-11 text-sm font-bold text-brand-ink hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface rounded"
                                >
                                    <span>Ajukan sesi percobaan</span>
                                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                                </Link>
                            </article>

                            <article class="flex flex-col flex-1 rounded-2xl bg-surface border border-line p-6">
                                <span class="w-12 h-12 rounded-xl bg-sky-soft text-sky flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-[26px]" aria-hidden="true">school</span>
                                </span>
                                <h3 class="text-lg font-bold text-ink mb-2">Pilih kelompok sesuai usia</h3>
                                <p class="text-sm text-ink-muted leading-relaxed mb-5">
                                    Bandingkan kurikulum, jadwal, dan rasio mentoring pada setiap kelompok belajar sebelum mendaftar.
                                </p>
                                <Link
                                     :href="program.url()"
                                    class="inline-flex items-center gap-1.5 self-start min-h-11 text-sm font-bold text-brand-ink hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface rounded"
                                >
                                    <span>Bandingkan program</span>
                                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                                </Link>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <!-- KUNJUNGI -->
            <section class="w-full py-14 lg:py-20 bg-surface-soft border-t border-line">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                        <div>
                            <span class="block text-xs font-bold uppercase tracking-wider text-brand-ink mb-3">Kunjungi sekolah</span>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-ink tracking-tight mb-4">
                                Datang, lihat sendiri suasananya
                            </h2>
                            <p class="text-base text-ink-muted leading-relaxed mb-6">
                                Sekolah berada di {{ kontakInfo.alamat }}, {{ kontakInfo.kota }}. Jadwalkan kunjungan pada jam kerja agar kami dapat menyesuaikan kebutuhan Anda.
                            </p>
                            <div class="flex flex-wrap gap-3">
                                <a
                                    :href="kontakInfo.whatsapp_link"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center justify-center gap-2 min-h-12 px-6 rounded-xl bg-brand text-on-brand font-bold hover:bg-brand-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft"
                                >
                                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">chat</span>
                                    <span>Chat WhatsApp humas</span>
                                </a>
                                <a
                                    :href="kontakInfo.telepon_link"
                                    class="inline-flex items-center justify-center gap-2 min-h-12 px-6 rounded-xl bg-surface text-brand-ink font-bold border border-line-strong hover:bg-surface-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft"
                                >
                                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">call</span>
                                    <span>{{ kontakInfo.telepon }}</span>
                                </a>
                            </div>
                        </div>

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-surface border border-line p-5">
                                <dt class="flex items-center gap-2 text-sm font-bold text-ink mb-2">
                                    <span class="material-symbols-outlined text-[18px] text-brand-ink" aria-hidden="true">schedule</span>
                                    Jam operasional
                                </dt>
                                <dd class="text-sm text-ink-muted leading-relaxed">
                                    <template v-for="(row, index) in kontakInfo.jam" :key="row.label">
                                        {{ row.label }} {{ row.value }}<template v-if="index < kontakInfo.jam.length - 1"><br /></template>
                                    </template>
                                </dd>
                            </div>
                            <div class="rounded-2xl bg-surface border border-line p-5">
                                <dt class="flex items-center gap-2 text-sm font-bold text-ink mb-2">
                                    <span class="material-symbols-outlined text-[18px] text-brand-ink" aria-hidden="true">location_on</span>
                                    Lokasi
                                </dt>
                                <dd class="text-sm text-ink-muted leading-relaxed">
                                    {{ kontakInfo.alamat }}<br />
                                    {{ kontakInfo.kota }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </section>
        </div>
    </GuestLayout>
</template>
