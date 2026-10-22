<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { home, kontak } from '@/routes';

type FilterId = 'semua' | 'reguler' | 'karakter' | 'agenda';
type Tone = 'brand' | 'sun' | 'sky' | 'coral';

type ProgramItem = {
    id: number;
    type: 'jenjang' | 'pilar' | 'sentra' | 'ekskul';
    name: string;
    short_name: string | null;
    age_range: string | null;
    category: string | null;
    summary: string | null;
    points: string[] | null;
    schedule: string | null;
    time: string | null;
    ratio: string | null;
    icon: string | null;
};

type AgendaItem = {
    id: number;
    semester: 'ganjil' | 'genap';
    month: string;
    icon: string | null;
    title: string;
    body: string;
    focus: string | null;
};

const props = defineProps<{
    programs: ProgramItem[];
    agendas: AgendaItem[];
}>();


const selectedFilter = ref<FilterId>('semua');
const activeSemester = ref<'ganjil' | 'genap'>('ganjil');

const filterOptions: Array<{ id: FilterId; label: string }> = [
    { id: 'semua', label: 'Semua program' },
    { id: 'reguler', label: 'Program reguler (KB, TK-A, TK-B)' },
    { id: 'karakter', label: 'Pilar karakter' },
    { id: 'agenda', label: 'Agenda kegiatan tahunan' },
];

const facts = [
    { label: 'Jenjang', value: '3 kelompok', note: 'Usia 3 sampai 6 tahun' },
    { label: 'Kurikulum', value: 'Merdeka PAUD', note: 'Kurikulum nasional' },
    { label: 'Rasio guru', value: '1 : 8 sampai 1 : 12', note: 'Perhatian intensif' },
    { label: 'Aktivitas', value: 'Setiap hari', note: 'Belajar sambil bermain' },
];

const jenjang = computed(() =>
    props.programs
        .filter((program) => program.type === 'jenjang')
        .map((program, index) => ({
            icon: program.icon ?? 'school',
            name: program.name,
            age: program.age_range ?? '',
            ageTone: (['sun', 'brand', 'sky'] as Tone[])[index % 3],
            summary: program.summary ?? '',
            points: program.points ?? [],
            schedule: program.schedule ?? '',
            time: program.time ?? '',
            ratio: program.ratio ?? '',
            action: `Jadwalkan kunjungan ${program.short_name ?? program.name}`,
        })),
);

const pilar = computed(() =>
    props.programs
        .filter((program) => program.type === 'pilar')
        .map((program, index) => ({
            icon: program.icon ?? 'auto_stories',
            tone: (['brand', 'sun', 'coral', 'sky'] as Tone[])[index % 4],
            category: program.category ?? '',
            title: program.name,
            body: program.summary ?? '',
            tag: (program.points ?? [])[0] ?? '',
            tagIcon: 'verified',
        })),
);

const sentra = computed(() => props.programs.filter((program) => program.type === 'sentra'));
const ekskul = computed(() => props.programs.filter((program) => program.type === 'ekskul'));

const agendaGanjil = computed(() => props.agendas.filter((agenda) => agenda.semester === 'ganjil'));
const agendaGenap = computed(() => props.agendas.filter((agenda) => agenda.semester === 'genap'));

const toneClasses = {
    brand: { chip: 'bg-brand-soft text-brand-on-soft', label: 'text-brand-ink', tile: 'bg-brand-soft text-brand-ink' },
    sun: { chip: 'bg-sun-soft text-sun-ink', label: 'text-sun-ink', tile: 'bg-sun-soft text-sun-ink' },
    sky: { chip: 'bg-sky-soft text-sky', label: 'text-sky', tile: 'bg-sky-soft text-sky' },
    coral: { chip: 'bg-coral-soft text-coral', label: 'text-coral', tile: 'bg-coral-soft text-coral' },
} as const;
</script>

<template>
    <GuestLayout>
        <Head title="Program dan Kegiatan | TK PGRI Tamansari" />

        <!-- Breadcrumb -->
        <div class="bg-surface-soft border-b border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-ink-subtle">
                <nav aria-label="Breadcrumb" class="flex items-center gap-1.5">
                    <Link
                         :href="home.url()"
                        class="hover:text-brand-ink flex items-center gap-1 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft rounded"
                    >
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">home</span>
                        <span>Beranda</span>
                    </Link>
                    <span aria-hidden="true">/</span>
                    <span class="text-ink font-semibold">Program dan Kegiatan</span>
                </nav>
                <Link
                     :href="kontak.url()"
                    class="inline-flex items-center gap-1.5 font-semibold text-brand-ink hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft rounded"
                >
                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">event_available</span>
                    <span>Kunjungan sekolah dapat dijadwalkan setiap hari kerja</span>
                </Link>
            </div>
        </div>

        <!-- Hero -->
        <section class="w-full bg-canvas pt-10 pb-14 lg:pb-16 border-b border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                    <div class="lg:col-span-7 flex flex-col gap-5">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-brand-soft text-brand-on-soft text-xs font-semibold w-fit">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">menu_book</span>
                            Kurikulum Merdeka PAUD dengan akar budaya Sunda
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight leading-tight">
                            Program edukasi holistik dan beragam kegiatan tumbuh kembang
                        </h1>
                        <p class="text-base sm:text-lg text-ink-muted leading-relaxed max-w-2xl">
                            Menumbuhkan potensi setiap ananda lewat pendekatan belajar sambil bermain yang gembira, penjelajahan alam kebun terbuka, pembiasaan adab Islami yang santun, serta sentuhan kearifan lokal Sunda yang memupuk rasa welas asih dan percaya diri.
                        </p>

                        <dl class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3">
                            <div v-for="fact in facts" :key="fact.label" class="flex flex-col gap-1 p-4 rounded-xl bg-surface border border-line">
                                <dt class="text-xs text-brand-ink uppercase font-bold tracking-wider">{{ fact.label }}</dt>
                                <dd class="text-base font-bold text-ink">{{ fact.value }}</dd>
                                <dd class="text-xs text-ink-subtle">{{ fact.note }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="lg:col-span-5">
                        <figure class="m-0 overflow-hidden rounded-2xl border border-line bg-surface">
                            <img
                                class="w-full h-[320px] sm:h-[400px] object-cover"
                                alt="Murid TK PGRI Tamansari belajar bermain balok"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAakYqKxDO7OIvGlocMQrt2s7KgQX9Ne-Om_ggV1gQvd_JpDMSXoUV2Yv_2EUUHsxXPG87rZ_Nn5r1BGmRjTuKS6yBPe_MItmxy2k5h8RlWkwr7WcV1wwJsrxfxmAp80YwzsNJQjSt5kyJhuwFE83mCw610WgnR1dr-TFw5a8DGPs3rO-7--dDmpn7hySNalP6hxOWURQu23Y49EIcP8pNdD2L0lGcff6326IGH80HpY6y5WN3ZKx_O"
                            />
                            <figcaption class="px-4 py-3 bg-black/60 text-white text-xs font-semibold flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-sun" aria-hidden="true">eco</span>
                                Eksplorasi dan sentuhan kreatif setiap hari
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter -->
        <section class="sticky top-20 z-40 w-full bg-surface/95 backdrop-blur-md border-y border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center gap-2 overflow-x-auto">
                    <button
                        v-for="item in filterOptions"
                        :key="item.id"
                        type="button"
                        :aria-pressed="selectedFilter === item.id"
                        @click="selectedFilter = item.id"
                        :class="[
                            'inline-flex items-center h-11 px-4 rounded-xl text-xs sm:text-sm font-semibold whitespace-nowrap transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
                            selectedFilter === item.id ? 'bg-brand text-on-brand' : 'text-ink-muted hover:text-brand-ink hover:bg-surface-soft',
                        ]"
                    >
                        {{ item.label }}
                    </button>
                </div>
            </div>
        </section>

        <div v-if="props.programs.length === 0 && props.agendas.length === 0" class="w-full bg-canvas py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="rounded-2xl bg-surface border border-line p-8 text-sm text-ink-muted">
                    Belum ada program atau agenda yang ditambahkan. Silakan hubungi sekolah untuk informasi kegiatan terbaru.
                </p>
            </div>
        </div>

        <!-- Jenjang program -->
        <section v-show="selectedFilter === 'semua' || selectedFilter === 'reguler'" class="w-full py-14 lg:py-20 bg-canvas">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="flex flex-col gap-1 max-w-2xl">
                        <span class="text-xs text-brand-ink font-bold uppercase tracking-wider">Fondasi pendidikan awal</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-ink">Jenjang program inti TK PGRI Tamansari</h2>
                        <p class="text-sm text-ink-muted">Tiga tahapan matang yang dirancang adaptif sesuai usia biologis dan perkembangan kognitif anak untuk memastikan transisi sekolah yang bahagia.</p>
                    </div>
                    <Link
                        :href="kontak.url()"
                        class="inline-flex items-center gap-1.5 px-3.5 min-h-11 rounded-xl bg-sun-soft text-sun-ink text-xs font-semibold self-start md:self-auto hover:bg-sun hover:text-on-sun transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft"
                    >
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">calendar_today</span>
                        <span>Jadwalkan Kunjungan Kelas</span>
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <article
                        v-for="item in jenjang"
                        :key="item.name"
                        class="flex flex-col rounded-2xl bg-surface border border-line p-6"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold" :class="toneClasses[item.ageTone].chip">
                                {{ item.age }}
                            </span>
                            <span class="w-11 h-11 rounded-xl flex items-center justify-center" :class="toneClasses[item.ageTone].tile">
                                <span class="material-symbols-outlined text-[24px]" aria-hidden="true">{{ item.icon }}</span>
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-ink">{{ item.name }}</h3>
                        <p class="text-xs text-ink-muted mt-1 mb-4">{{ item.summary }}</p>

                        <ul class="flex flex-col gap-2 p-4 rounded-xl bg-surface-soft border border-line mb-5">
                            <li v-for="point in item.points" :key="point" class="flex items-start gap-2 text-xs text-ink-muted">
                                <span class="material-symbols-outlined text-[18px] text-brand-ink shrink-0" aria-hidden="true">check_circle</span>
                                <span>{{ point }}</span>
                            </li>
                        </ul>

                        <dl class="flex flex-col gap-2 text-xs text-ink-muted mb-6">
                            <div class="flex justify-between items-center gap-3 py-2 px-3 rounded-lg bg-surface-soft">
                                <dt>Jadwal belajar</dt>
                                <dd class="font-bold text-ink">{{ item.schedule }}</dd>
                            </div>
                            <div class="flex justify-between items-center gap-3 py-2 px-3 rounded-lg bg-surface-soft">
                                <dt>Waktu</dt>
                                <dd class="font-bold text-ink">{{ item.time }}</dd>
                            </div>
                            <div class="flex justify-between items-center gap-3 py-2 px-3 rounded-lg bg-surface-soft">
                                <dt>Rasio kelas</dt>
                                <dd class="font-bold text-brand-ink">{{ item.ratio }}</dd>
                            </div>
                        </dl>

                        <Link
                             :href="kontak.url()"
                            class="mt-auto inline-flex items-center justify-center gap-2 min-h-11 px-4 rounded-xl bg-brand text-on-brand text-sm font-semibold hover:bg-brand-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        >
                            {{ item.action }}
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_forward</span>
                        </Link>
                    </article>
                </div>
            </div>
        </section>

        <!-- Pilar karakter -->
        <section v-show="selectedFilter === 'semua' || selectedFilter === 'karakter'" class="w-full py-14 lg:py-20 bg-surface-soft border-y border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
                <div class="flex flex-col max-w-3xl gap-1">
                    <span class="text-xs text-brand-ink font-bold uppercase tracking-wider">Ciri khas sekolah</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-ink">Empat pilar karakter</h2>
                    <p class="text-sm text-ink-muted">
                        Empat nilai khas yang membentuk karakter mulia, cinta lingkungan, wawasan budaya, dan literasi mendalam sejak dini.
                    </p>
                </div>

                <ol class="flex flex-col rounded-2xl bg-surface border border-line divide-y divide-line">
                    <li v-for="item in pilar" :key="item.title" class="flex flex-col sm:flex-row sm:items-start gap-4 p-6">
                        <span class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" :class="toneClasses[item.tone].tile">
                            <span class="material-symbols-outlined text-[26px]" aria-hidden="true">{{ item.icon }}</span>
                        </span>
                        <div class="flex flex-col gap-1 flex-1">
                            <span class="text-xs font-bold uppercase" :class="toneClasses[item.tone].label">
                                {{ item.category }}
                            </span>
                            <h3 class="text-lg font-bold text-ink">{{ item.title }}</h3>
                            <p class="text-sm text-ink-muted leading-relaxed">{{ item.body }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-ink-muted shrink-0 sm:self-center">
                            <span class="material-symbols-outlined text-[18px] text-brand-ink" aria-hidden="true">{{ item.tagIcon }}</span>
                            {{ item.tag }}
                        </span>
                    </li>
                </ol>
            </div>
        </section>

        <!-- Sentra dan ekstrakurikuler -->
        <section v-show="selectedFilter === 'semua'" class="w-full py-14 lg:py-20 bg-canvas">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
                <div class="flex flex-col max-w-3xl gap-1">
                    <span class="text-xs text-brand-ink font-bold uppercase tracking-wider">Ruang eksplorasi dan bakat</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-ink">Sentra belajar dan ekstrakurikuler</h2>
                    <p class="text-sm text-ink-muted">
                        Pendekatan sentra memberi anak ruang mengeksplorasi minat, sementara ekstrakurikuler mempertajam bakat dan keberanian tampil.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="rounded-2xl bg-surface border border-line p-6">
                        <h3 class="text-lg font-bold text-ink mb-4">Sentra pembelajaran</h3>
                        <ul class="flex flex-col divide-y divide-line">
                            <li v-for="program in sentra" :key="program.id" class="flex items-start gap-3 py-4 first:pt-0 last:pb-0">
                                <span class="w-10 h-10 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">{{ program.icon ?? 'architecture' }}</span>
                                </span>
                                <div class="flex flex-col gap-1">
                                    <h4 class="text-sm font-bold text-ink">{{ program.name }}</h4>
                                    <p class="text-xs text-ink-muted leading-relaxed">{{ program.summary }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-2xl bg-surface border border-line p-6">
                        <h3 class="text-lg font-bold text-ink mb-4">Ekstrakurikuler</h3>
                        <ul class="flex flex-col divide-y divide-line">
                            <li v-for="club in ekskul" :key="club.id" class="flex items-start justify-between gap-3 py-4 first:pt-0 last:pb-0">
                                <div class="flex flex-col gap-0.5">
                                    <h4 class="text-sm font-bold text-ink">{{ club.name }}</h4>
                                    <p class="text-xs text-ink-muted">{{ club.summary }}</p>
                                </div>
                                <span class="text-xs font-semibold text-brand-ink shrink-0">{{ club.schedule }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Agenda tahunan -->
        <section v-show="selectedFilter === 'semua' || selectedFilter === 'agenda'" class="w-full py-14 lg:py-20 bg-canvas">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="flex flex-col gap-1 max-w-2xl">
                        <span class="text-xs text-brand-ink font-bold uppercase tracking-wider">Perjalanan satu tahun belajar</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-ink">Agenda kegiatan tahunan</h2>
                        <p class="text-sm text-ink-muted">Rangkaian acara tahunan yang memperkaya pengalaman dunia nyata anak melalui kolaborasi erat sekolah, orang tua, dan masyarakat.</p>
                    </div>

                    <div class="inline-flex p-1 gap-1 rounded-xl bg-surface border border-line self-start">
                        <button
                            type="button"
                            :aria-pressed="activeSemester === 'ganjil'"
                            @click="activeSemester = 'ganjil'"
                            :class="[
                                'inline-flex items-center h-11 px-4 rounded-xl text-xs font-bold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
                                activeSemester === 'ganjil' ? 'bg-brand text-on-brand' : 'text-ink-muted hover:bg-surface-soft',
                            ]"
                        >
                            Semester ganjil (Jul - Des)
                        </button>
                        <button
                            type="button"
                            :aria-pressed="activeSemester === 'genap'"
                            @click="activeSemester = 'genap'"
                            :class="[
                                'inline-flex items-center h-11 px-4 rounded-xl text-xs font-bold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface',
                                activeSemester === 'genap' ? 'bg-brand text-on-brand' : 'text-ink-muted hover:bg-surface-soft',
                            ]"
                        >
                            Semester genap (Jan - Jun)
                        </button>
                    </div>
                </div>

                <ol v-show="activeSemester === 'ganjil'" class="flex flex-col rounded-2xl bg-surface border border-line divide-y divide-line">
                    <li v-for="event in agendaGanjil" :key="event.title" class="flex flex-col sm:flex-row sm:items-start gap-4 p-5 sm:p-6">
                        <div class="flex sm:w-44 sm:shrink-0 items-center gap-2">
                            <span class="material-symbols-outlined text-[22px] text-brand-ink" aria-hidden="true">{{ event.icon }}</span>
                            <span class="px-3 py-1 rounded-full bg-brand-soft text-brand-on-soft text-xs font-bold">{{ event.month }}</span>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <h3 class="text-base font-bold text-ink">{{ event.title }}</h3>
                            <p class="text-sm text-ink-muted leading-relaxed">{{ event.body }}</p>
                        </div>
                        <p class="text-xs text-ink-subtle shrink-0 sm:self-center sm:text-right sm:max-w-40">Fokus: {{ event.focus }}</p>
                    </li>
                </ol>

                <ol v-show="activeSemester === 'genap'" class="flex flex-col rounded-2xl bg-surface border border-line divide-y divide-line">
                    <li v-for="event in agendaGenap" :key="event.title" class="flex flex-col sm:flex-row sm:items-start gap-4 p-5 sm:p-6">
                        <div class="flex sm:w-44 sm:shrink-0 items-center gap-2">
                            <span class="material-symbols-outlined text-[22px] text-brand-ink" aria-hidden="true">{{ event.icon }}</span>
                            <span class="px-3 py-1 rounded-full bg-brand-soft text-brand-on-soft text-xs font-bold">{{ event.month }}</span>
                        </div>
                        <div class="flex flex-col gap-1 flex-1">
                            <h3 class="text-base font-bold text-ink">{{ event.title }}</h3>
                            <p class="text-sm text-ink-muted leading-relaxed">{{ event.body }}</p>
                        </div>
                        <p class="text-xs text-ink-subtle shrink-0 sm:self-center sm:text-right sm:max-w-40">Fokus: {{ event.focus }}</p>
                    </li>
                </ol>
            </div>
        </section>
    </GuestLayout>
</template>
