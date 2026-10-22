<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { home } from '@/routes';
import { show as beritaShow } from '@/routes/berita';

type GalleryItem = {
    id: number;
    title: string;
    desc: string;
    category: string;
    categoryLabel: string;
    date: string;
    location: string;
    image: string;
};

const selectedCategory = ref<string>('all');
const searchQuery = ref<string>('');
const selectedImage = ref<GalleryItem | null>(null);
const closeButton = ref<HTMLButtonElement | null>(null);
const lastFocused = ref<HTMLElement | null>(null);

type GaleriApiItem = {
    id: number;
    title: string;
    description: string | null;
    image_url: string | null;
    date_label: string | null;
    location: string | null;
    kategori: { nama: string; slug: string } | null;
};

const props = defineProps<{
    items: GaleriApiItem[];
    kategoris: Array<{ id: number; slug: string; nama: string }>;
}>();

const categories = computed(() => [
    { id: 'all', label: 'Semua dokumentasi' },
    ...props.kategoris.map((kategori) => ({ id: kategori.slug, label: kategori.nama })),
]);

const galleryItems = computed<GalleryItem[]>(() =>
    props.items.map((item) => ({
        id: item.id,
        title: item.title,
        desc: item.description ?? '',
        category: item.kategori?.slug ?? 'lainnya',
        categoryLabel: item.kategori?.nama ?? 'Dokumentasi',
        date: item.date_label ?? '',
        location: item.location ?? '',
        image: item.image_url ?? '',
    })),
);

const filteredItems = computed(() => {
    const keyword = searchQuery.value.trim().toLowerCase();

    return galleryItems.value.filter((item) => {
        const matchesCategory = selectedCategory.value === 'all' || item.category === selectedCategory.value;
        const matchesSearch =
            keyword === '' ||
            item.title.toLowerCase().includes(keyword) ||
            item.desc.toLowerCase().includes(keyword) ||
            item.location.toLowerCase().includes(keyword);

        return matchesCategory && matchesSearch;
    });
});

function openImage(item: GalleryItem): void {
    lastFocused.value = document.activeElement as HTMLElement | null;
    selectedImage.value = item;
}

function closeImage(): void {
    selectedImage.value = null;
    lastFocused.value?.focus();
}

function onKeydown(event: KeyboardEvent): void {
    if (event.key === 'Escape' && selectedImage.value !== null) {
        closeImage();
    }
}

watch(selectedImage, (value) => {
    document.body.style.overflow = value ? 'hidden' : '';

    if (value !== null) {
        nextTick(() => closeButton.value?.focus());
    }
});

onMounted(() => window.addEventListener('keydown', onKeydown));
onUnmounted(() => {
    window.removeEventListener('keydown', onKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <GuestLayout>
        <Head title="Galeri Foto dan Dokumentasi | TK PGRI Tamansari" />

        <div class="w-full bg-canvas pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-ink-subtle mb-6">
                    <Link
                         :href="home.url()"
                        class="hover:text-brand-ink flex items-center gap-1 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas rounded"
                    >
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">home</span>
                        <span>Beranda</span>
                    </Link>
                    <span aria-hidden="true">/</span>
                    <span class="text-ink font-semibold">Galeri foto dan kegiatan</span>
                </nav>

                <!-- Page header -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-soft text-brand-on-soft text-xs font-semibold mb-3 w-fit">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">photo_library</span>
                            Dokumentasi kegiatan sekolah
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight mb-3">
                            Galeri momen belajar dan <span class="text-brand-ink underline decoration-sun decoration-wavy decoration-2">bermain si kecil</span>
                        </h1>
                        <p class="text-base sm:text-lg text-ink-muted">
                            Rekaman jejak keceriaan, kreativitas, dan eksplorasi dunia ananda di lingkungan asri dan penuh kasih TK PGRI Tamansari.
                        </p>
                    </div>
                </div>

                <!-- Featured activity -->
                <article class="overflow-hidden rounded-2xl bg-surface border border-line mb-12">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        <div class="lg:col-span-7 relative h-72 lg:h-auto overflow-hidden">
                            <img
                                class="w-full h-full object-cover"
                                alt="Parade busana adat dalam peringatan Hari Kartini"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJZDCROzmiO_EyNDi5BL05sf66nBriJrV9NsiBfVKNaP85rv0bmr6Z5HGszEPg_HeoLKC4iuw4UJKGA4B_uuy-23U_2hBPlCbwJr7xNy56SIGwgFB9-iJidTKXx0hUYn1Dwkgd6b_HhjpovHT3OwimEI3Pcax4Rwllft60GgoAisuobgjZsL-zyzD_vgoe_MR5Gy77fYAiNAptrrHX7LrrPvOfTc8nvqpzedPQWSZ48hCIBMKz0NTD"
                            />
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-xl bg-sun text-on-sun text-xs font-bold">Kegiatan siswa dan budaya</span>
                        </div>

                        <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 flex flex-col justify-between gap-6 bg-surface-soft">
                            <div>
                                <p class="flex items-center gap-2 text-xs text-ink-subtle mb-2">
                                    <span class="material-symbols-outlined text-[16px] text-brand-ink" aria-hidden="true">event</span>
                                    <span>24 Oktober 2024</span>
                                </p>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-ink leading-snug mb-3">
                                    Semarak parade budaya dan peringatan Hari Kartini
                                </h2>
                                <p class="text-sm text-ink-muted leading-relaxed">
                                    Menanamkan cinta tanah air sejak dini melalui parade pakaian adat Nusantara yang penuh senyum, tawa, dan rasa bangga ananda bersama orang tua dan pendidik.
                                </p>
                            </div>
                            <div class="pt-4 border-t border-line">
                                <Link
                                     :href="beritaShow.url({ slug: 'hari-kartini-2024' })"
                                    class="inline-flex items-center justify-center gap-2 min-h-11 px-5 rounded-xl bg-brand text-on-brand text-xs sm:text-sm font-bold hover:bg-brand-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft"
                                >
                                    <span>Baca artikel kegiatan</span>
                                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">arrow_forward</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Search and filters -->
                <div class="flex flex-col gap-4 mb-6">
                    <div class="w-full md:w-96">
                        <label for="galeri-search" class="sr-only">Cari dokumentasi</label>
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined text-ink-subtle absolute left-3.5 text-[20px]" aria-hidden="true">search</span>
                            <input
                                id="galeri-search"
                                v-model="searchQuery"
                                type="search"
                                class="w-full pl-10 pr-4 h-11 rounded-xl bg-surface text-ink placeholder:text-ink-subtle text-sm border border-line focus:outline-none focus:ring-2 focus:ring-focus"
                                placeholder="Cari kegiatan atau lokasi"
                            />
                        </div>
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto pb-1">
                        <button
                            v-for="cat in categories"
                            :key="cat.id"
                            type="button"
                            :aria-pressed="selectedCategory === cat.id"
                            @click="selectedCategory = cat.id"
                            :class="[
                                'inline-flex items-center h-11 px-4 rounded-xl text-xs sm:text-sm font-semibold whitespace-nowrap transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas',
                                selectedCategory === cat.id
                                    ? 'bg-brand text-on-brand'
                                    : 'bg-surface text-ink-muted border border-line hover:text-brand-ink hover:bg-surface-soft',
                            ]"
                        >
                            {{ cat.label }}
                        </button>
                    </div>

                    <p class="text-xs text-ink-subtle" aria-live="polite">
                        Menampilkan {{ filteredItems.length }} dari {{ galleryItems.length }} dokumentasi.
                    </p>
                </div>

                <!-- Gallery grid -->
                <div v-if="filteredItems.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <article
                        v-for="item in filteredItems"
                        :key="item.id"
                        class="flex flex-col overflow-hidden rounded-2xl bg-surface border border-line"
                    >
                        <button
                            type="button"
                            @click="openImage(item)"
                            class="relative w-full h-64 overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        >
                            <img class="w-full h-full object-cover" :alt="item.title" :src="item.image" />
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-xl bg-sun text-on-sun text-xs font-bold">{{ item.categoryLabel }}</span>
                            <span class="absolute top-3 right-3 px-3 py-1 rounded-xl bg-black/60 text-white text-xs font-semibold">{{ item.date }}</span>
                            <span class="absolute bottom-3 left-3 inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-black/60 text-white text-xs font-semibold">
                                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">zoom_in</span>
                                Perbesar
                            </span>
                        </button>

                        <div class="p-5 flex flex-col flex-1 gap-2">
                            <h3 class="text-base font-bold text-ink leading-snug">{{ item.title }}</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">{{ item.desc }}</p>
                            <p class="mt-auto pt-3 border-t border-line text-xs text-ink-subtle flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-brand-ink" aria-hidden="true">location_on</span>
                                {{ item.location }}
                            </p>
                        </div>
                    </article>
                </div>

                <div v-else class="rounded-2xl bg-surface border border-line p-10 text-center">
                    <span class="material-symbols-outlined text-[40px] text-ink-subtle" aria-hidden="true">image_not_supported</span>
                    <p class="text-sm text-ink-muted mt-3">Dokumentasi yang cocok belum tersedia. Ubah kata kunci atau pilih kategori lain.</p>
                </div>
            </div>
        </div>

        <!-- Lightbox -->
        <div
            v-if="selectedImage"
            class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4"
            @click.self="closeImage"
        >
            <div
                role="dialog"
                aria-modal="true"
                :aria-label="selectedImage.title"
                class="relative bg-surface rounded-2xl overflow-hidden max-w-3xl w-full"
            >
                <div class="relative h-72 sm:h-96 w-full">
                    <img :src="selectedImage.image" :alt="selectedImage.title" class="w-full h-full object-cover" />
                    <button
                        ref="closeButton"
                        type="button"
                        @click="closeImage"
                        class="absolute top-4 right-4 w-11 h-11 rounded-xl bg-black/60 text-white flex items-center justify-center hover:bg-black transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-black"
                    >
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                        <span class="sr-only">Tutup pratinjau foto</span>
                    </button>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-ink mb-1">{{ selectedImage.title }}</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">{{ selectedImage.desc }}</p>
                    <p class="text-xs text-ink-subtle mt-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">location_on</span>
                        {{ selectedImage.location }}
                    </p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
