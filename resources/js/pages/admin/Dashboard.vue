<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

type BeritaRow = {
    id: number;
    slug: string;
    title: string;
    category: string;
    published_at: string | null;
};

type MessageRow = {
    id: number;
    nama_orang_tua: string;
    nomor_whatsapp: string;
    program_interest: string | null;
    status: 'baru' | 'diproses' | 'selesai';
    created_at: string;
};

defineProps<{
    stats: {
        berita: number;
        berita_terbit: number;
        galeri: number;
        program: number;
        pesan_baru: number;
    };
    recentBerita: BeritaRow[];
    recentMessages: MessageRow[];
}>();

const formatDate = (value: string | null): string =>
    value ? new Date(value).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : 'Draft';

const statusLabel = (status: MessageRow['status']): string => {
    if (status === 'diproses') {
        return 'Diproses';
    }

    if (status === 'selesai') {
        return 'Selesai';
    }

    return 'Baru';
};
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard Admin" />

        <div class="space-y-6">
            <div class="relative overflow-hidden rounded-3xl bg-[#006738] text-white shadow-sm p-6 sm:p-8 lg:p-10">
                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="max-w-2xl space-y-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-white text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                            Portal Admin
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat datang di rumah TK PGRI Tamansari</h1>
                        <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                            Kelola berita, program, agenda, galeri, profil sekolah, dan pesan orang tua dari satu tempat.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        <Link
                            href="/admin/berita/create"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#F5A623] text-gray-900 text-xs sm:text-sm font-bold shadow-md hover:bg-[#e0951b] transition-all"
                        >
                            <span class="material-symbols-outlined text-[18px]">add_circle</span>
                            <span>Tulis Berita</span>
                        </Link>
                        <Link
                            href="/"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-[#006738] text-xs sm:text-sm font-bold shadow-sm hover:bg-emerald-50 transition-all"
                        >
                            <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                            <span>Lihat Website</span>
                        </Link>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#006738] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">newspaper</span>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mt-4">Berita</p>
                    <p class="text-2xl font-extrabold text-gray-900 mt-0.5">{{ stats.berita }}</p>
                    <p class="text-xs text-[#006738] font-medium mt-1">{{ stats.berita_terbit }} terbit</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#835500] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">photo_library</span>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mt-4">Foto Galeri</p>
                    <p class="text-2xl font-extrabold text-gray-900 mt-0.5">{{ stats.galeri }}</p>
                    <p class="text-xs text-gray-500 font-medium mt-1">Dokumentasi kegiatan</p>
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#005e90] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">school</span>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mt-4">Program Aktif</p>
                    <p class="text-2xl font-extrabold text-gray-900 mt-0.5">{{ stats.program }}</p>
                    <p class="text-xs text-gray-500 font-medium mt-1">Jenjang, pilar, sentra, ekskul</p>
                </div>

                <Link href="/admin/pesan" class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100 hover:border-emerald-200 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">mark_email_unread</span>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mt-4">Pesan Baru</p>
                    <p class="text-2xl font-extrabold text-gray-900 mt-0.5">{{ stats.pesan_baru }}</p>
                    <p class="text-xs text-[#006738] font-medium mt-1">Buka kotak masuk</p>
                </Link>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 rounded-3xl bg-white shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 flex items-center justify-between gap-4 border-b border-gray-100">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Berita terbaru</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Lima artikel terakhir yang dikelola.</p>
                        </div>
                        <Link href="/admin/berita" class="text-xs font-bold text-[#006738] hover:underline">Lihat semua</Link>
                    </div>

                    <div v-if="recentBerita.length === 0" class="p-6 text-sm text-gray-500">
                        Belum ada berita. Mulai dengan menulis berita pertama.
                    </div>

                    <div v-else class="divide-y divide-gray-50">
                        <Link
                            v-for="item in recentBerita"
                            :key="item.id"
                            :href="`/admin/berita/${item.slug}/edit`"
                            class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-emerald-50/30 transition-colors"
                        >
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ item.title }}</p>
                                <p class="text-xs text-[#006738] font-semibold mt-0.5">{{ item.category }}</p>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ formatDate(item.published_at) }}</span>
                        </Link>
                    </div>
                </div>

                <div class="rounded-3xl bg-white shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 flex items-center justify-between gap-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Pesan terbaru</h2>
                        <Link href="/admin/pesan" class="text-xs font-bold text-[#006738] hover:underline">Semua</Link>
                    </div>

                    <div v-if="recentMessages.length === 0" class="p-6 text-sm text-gray-500">
                        Belum ada pesan dari orang tua.
                    </div>

                    <div v-else class="divide-y divide-gray-50">
                        <div v-for="message in recentMessages" :key="message.id" class="px-6 py-4 flex flex-col gap-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ message.nama_orang_tua }}</p>
                                <span
                                    :class="[
                                        'px-2 py-0.5 rounded-full text-xs font-bold',
                                        message.status === 'baru'
                                            ? 'bg-emerald-100 text-[#006738]'
                                            : message.status === 'diproses'
                                              ? 'bg-amber-100 text-[#835500]'
                                              : 'bg-gray-100 text-gray-600',
                                    ]"
                                >
                                    {{ statusLabel(message.status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500">{{ message.nomor_whatsapp }}</p>
                            <p class="text-xs text-gray-500">{{ message.program_interest ?? 'Konsultasi umum' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
