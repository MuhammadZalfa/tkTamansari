<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { home } from '@/routes';

type TabId = 'sejarah' | 'visi-misi' | 'pendidik' | 'fasilitas';

type ProfilSettings = {
    sambutan?: Record<string, any>;
    sejarah?: Record<string, any>;
    visi?: Record<string, any>;
    misi?: Array<{ icon: string; title: string; body: string }>;
    fakta?: Array<{ label: string; value: string }>;
    fasilitas?: Array<{ title: string; body: string; image: string | null }>;
};

type TeacherRole = {
    id: number;
    role: string;
    focus: string;
    points: string[];
};

const props = defineProps<{
    profil: ProfilSettings;
    teachers: TeacherRole[];
}>();

const activeTab = ref<TabId>('sejarah');

const tabs = [
    { id: 'sejarah' as TabId, label: 'Sejarah dan Deskripsi', icon: 'history_edu' },
    { id: 'visi-misi' as TabId, label: 'Visi, Misi dan Tujuan', icon: 'flag' },
    { id: 'pendidik' as TabId, label: 'Peran Pendidik', icon: 'groups' },
    { id: 'fasilitas' as TabId, label: 'Sarana dan Prasarana', icon: 'meeting_room' },
];

const facts = computed(() => props.profil.fakta ?? []);

const misi = computed(() => props.profil.misi ?? []);

const sejarah = computed(() => props.profil.sejarah ?? {});
const visi = computed(() => props.profil.visi ?? {});
const fasilitas = computed(() => props.profil.fasilitas ?? []);

const peran = computed(() => props.teachers);

const roleIcon = (role: string): string => {
    if (role.includes('Kepala')) {
        return 'workspace_premium';
    }

    if (role.includes('Kelompok Bermain')) {
        return 'toys';
    }

    if (role.includes('TK-A')) {
        return 'palette';
    }

    if (role.includes('TK-B')) {
        return 'calculate';
    }

    return 'groups';
};
</script>

<template>
    <GuestLayout>
        <Head title="Profil Sekolah | TK PGRI Tamansari" />

        <!-- Breadcrumb -->
        <div class="bg-surface-soft border-b border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-2 text-xs text-ink-subtle">
                <Link
                     :href="home.url()"
                    class="hover:text-brand-ink flex items-center gap-1 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft rounded"
                >
                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">home</span>
                    <span>Beranda</span>
                </Link>
                <span aria-hidden="true">/</span>
                <span class="text-ink font-semibold">Profil Sekolah</span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <!-- HERO PROFIL -->
            <section class="w-full rounded-2xl bg-surface border border-line p-6 sm:p-10 mb-10">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-8">
                    <div class="max-w-3xl flex flex-col gap-4">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight leading-tight">
                            Profil <span class="text-brand-ink underline decoration-sun decoration-wavy decoration-2">TK PGRI Tamansari</span>
                        </h1>

                        <p class="text-base sm:text-lg text-ink-muted max-w-2xl leading-relaxed">
                            Mengenal lebih dekat lingkungan belajar asri, nilai keteladanan, peran pendidik, serta sarana ramah anak yang dirancang untuk kebahagiaan si kecil.
                        </p>

                        <ul class="flex flex-wrap items-center gap-2 pt-2">
                            <li class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-surface-soft border border-line text-xs font-semibold text-ink">
                                <span class="material-symbols-outlined text-[16px] text-brand-ink" aria-hidden="true">menu_book</span>
                                Kurikulum Merdeka PAUD
                            </li>
                            <li class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-surface-soft border border-line text-xs font-semibold text-ink">
                                <span class="material-symbols-outlined text-[16px] text-sun-ink" aria-hidden="true">child_care</span>
                                Rasio 1 guru : 12 murid
                            </li>
                            <li class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-surface-soft border border-line text-xs font-semibold text-ink">
                                <span class="material-symbols-outlined text-[16px] text-sky" aria-hidden="true">volunteer_activism</span>
                                Sekolah ramah anak
                            </li>
                        </ul>
                    </div>

                    <!-- Fakta sekolah -->
                    <div class="w-full lg:w-72 shrink-0 rounded-2xl bg-surface-soft border border-line p-5">
                        <span class="text-xs font-bold uppercase tracking-wider text-ink-subtle">Fakta sekolah</span>
                        <dl class="mt-4 flex flex-col divide-y divide-line">
                            <div v-for="fact in facts" :key="fact.label" class="py-3 flex flex-col gap-0.5 first:pt-0 last:pb-0">
                                <dt class="text-xs text-ink-subtle">{{ fact.label }}</dt>
                                <dd class="text-sm font-bold text-ink">{{ fact.value }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </section>

            <!-- TABS -->
            <section class="sticky top-20 z-40 w-full mb-10">
                <div class="bg-surface/95 backdrop-blur-md p-2 rounded-2xl border border-line flex items-center justify-start sm:justify-center overflow-x-auto gap-2">
                    <div role="tablist" aria-label="Bagian profil sekolah" class="flex items-center gap-2">
                        <button
                            v-for="tab in tabs"
                            :id="`tab-${tab.id}`"
                            :key="tab.id"
                            type="button"
                            role="tab"
                            :aria-selected="activeTab === tab.id"
                            :aria-controls="`panel-${tab.id}`"
                            @click="activeTab = tab.id"
                            :class="[
                                'inline-flex items-center gap-2 h-11 px-4 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
                                activeTab === tab.id
                                    ? 'bg-brand text-on-brand'
                                    : 'text-ink-muted hover:text-brand-ink hover:bg-surface-soft',
                            ]"
                        >
                            <span class="material-symbols-outlined text-[20px]" aria-hidden="true">{{ tab.icon }}</span>
                            <span>{{ tab.label }}</span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- PANEL: SEJARAH -->
            <div
                v-show="activeTab === 'sejarah'"
                id="panel-sejarah"
                role="tabpanel"
                aria-labelledby="tab-sejarah"
                tabindex="0"
                class="flex flex-col gap-12 focus-visible:outline-none"
            >
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    <div class="lg:col-span-6 flex flex-col gap-4">
                        <div class="rounded-2xl overflow-hidden bg-surface border border-line">
                            <img
                                class="w-full h-[320px] sm:h-[380px] object-cover"
                                alt="Gedung dan halaman utama TK PGRI Tamansari"
                                :src="sejarah.foto ?? ''"
                            />
                        </div>

                        <div class="p-6 bg-sun-soft rounded-2xl border border-line">
                            <p class="text-sm sm:text-base text-sun-ink font-semibold italic leading-relaxed">
                                "{{ sejarah.quote }}"
                            </p>
                            <span class="text-xs text-ink-subtle mt-2 block">{{ sejarah.quote_credit }}</span>
                        </div>
                    </div>

                    <div class="lg:col-span-6 flex flex-col gap-5">
                        <span class="text-xs font-bold uppercase tracking-wider text-brand-ink">Kilas balik sejarah</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-ink leading-tight">
                            {{ sejarah.judul }}
                        </h2>
                        <div class="flex flex-col gap-4 text-sm sm:text-base text-ink-muted leading-relaxed">
                            <p>{{ sejarah.paragraf1 }}</p>
                            <p>{{ sejarah.paragraf2 }}</p>
                        </div>

                        <dl class="grid grid-cols-2 gap-3 pt-2">
                            <div v-for="fact in facts" :key="fact.label" class="p-4 rounded-2xl bg-surface border border-line">
                                <dt class="text-xs text-ink-subtle">{{ fact.label }}</dt>
                                <dd class="text-lg font-extrabold text-brand-ink mt-1">{{ fact.value }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- PANEL: VISI MISI -->
            <div
                v-show="activeTab === 'visi-misi'"
                id="panel-visi-misi"
                role="tabpanel"
                aria-labelledby="tab-visi-misi"
                tabindex="0"
                class="flex flex-col gap-10 focus-visible:outline-none"
            >
                <div class="rounded-2xl bg-brand text-on-brand p-8 lg:p-10">
                    <div class="flex flex-col gap-4 max-w-3xl">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-on-brand/15 text-xs font-semibold w-fit">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">auto_awesome</span>
                            Visi utama sekolah
                        </span>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold leading-snug">
                            "{{ visi.utama }}"
                        </p>
                        <p class="text-sm sm:text-base text-on-brand/85">
                            {{ visi.deskripsi }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="max-w-2xl">
                        <span class="text-xs font-bold text-brand-ink uppercase tracking-wider">Langkah konkret</span>
                        <h3 class="text-2xl font-bold text-ink mt-1">Misi pembinaan generasi</h3>
                        <p class="text-sm text-ink-muted mt-1">Empat arah yang diterjemahkan ke dalam aktivitas harian anak di sekolah.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <article
                            v-for="item in misi"
                            :key="item.title"
                            class="p-6 rounded-2xl bg-surface border border-line flex items-start gap-4"
                        >
                            <span class="w-12 h-12 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[26px]" aria-hidden="true">{{ item.icon }}</span>
                            </span>
                            <div class="flex flex-col gap-1">
                                <h4 class="text-base font-bold text-ink">{{ item.title }}</h4>
                                <p class="text-sm text-ink-muted leading-relaxed">{{ item.body }}</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <!-- PANEL: PENDIDIK -->
            <div
                v-show="activeTab === 'pendidik'"
                id="panel-pendidik"
                role="tabpanel"
                aria-labelledby="tab-pendidik"
                tabindex="0"
                class="flex flex-col gap-10 focus-visible:outline-none"
            >
                <div class="flex flex-col gap-2 max-w-2xl">
                    <span class="text-xs font-bold text-brand-ink uppercase tracking-wider">Peran pendidik</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-ink">Siapa mendampingi anak setiap hari</h2>
                    <p class="text-sm text-ink-muted">
                        Setiap kelas ditangani pendidik berlatar PG-PAUD yang mendampingi anak dengan kehangatan seorang ibu. Berikut pembagian peran di kelas.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <article
                        v-for="item in peran"
                        :key="item.role"
                        class="flex flex-col rounded-2xl bg-surface border border-line p-6"
                    >
                        <span class="w-12 h-12 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-[26px]" aria-hidden="true">{{ roleIcon(item.role) }}</span>
                        </span>
                        <h3 class="text-lg font-bold text-ink mb-2">{{ item.role }}</h3>
                        <p class="text-sm text-ink-muted leading-relaxed mb-4">{{ item.focus }}</p>
                        <ul class="mt-auto flex flex-col gap-2 pt-4 border-t border-line">
                            <li v-for="point in item.points" :key="point" class="flex items-start gap-2 text-xs text-ink-muted">
                                <span class="material-symbols-outlined text-[16px] text-brand-ink shrink-0" aria-hidden="true">check_circle</span>
                                <span>{{ point }}</span>
                            </li>
                        </ul>
                    </article>
                </div>
            </div>

            <!-- PANEL: FASILITAS -->
            <div
                v-show="activeTab === 'fasilitas'"
                id="panel-fasilitas"
                role="tabpanel"
                aria-labelledby="tab-fasilitas"
                tabindex="0"
                class="flex flex-col gap-10 focus-visible:outline-none"
            >
                <div class="flex flex-col gap-2 max-w-2xl">
                    <span class="text-xs font-bold text-brand-ink uppercase tracking-wider">Fasilitas ramah anak</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-ink">Sarana dan prasarana</h2>
                    <p class="text-sm text-ink-muted">Semua fasilitas didesain dengan standar keselamatan tinggi, sudut tumpul ramah anak, dan higienitas berkala.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <article
                        v-for="item in fasilitas"
                        :key="item.title"
                        class="flex flex-col overflow-hidden rounded-2xl bg-surface border border-line"
                    >
                        <div class="h-48 overflow-hidden">
                            <img class="w-full h-full object-cover" :alt="item.title" :src="item.image ?? ''" />
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-ink mb-2">{{ item.title }}</h3>
                            <p class="text-sm text-ink-muted leading-relaxed">{{ item.body }}</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
