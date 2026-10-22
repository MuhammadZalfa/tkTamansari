<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Message = {
    id: number;
    nama_orang_tua: string;
    nomor_whatsapp: string;
    nama_ananda: string | null;
    program_interest: string | null;
    tanggal_kunjungan: string | null;
    pesan: string | null;
    status: 'baru' | 'diproses' | 'selesai';
    created_at: string;
};

const props = defineProps<{
    messages: Message[];
    status: string;
}>();

const filters = [
    { id: '', label: 'Semua' },
    { id: 'baru', label: 'Baru' },
    { id: 'diproses', label: 'Diproses' },
    { id: 'selesai', label: 'Selesai' },
];

const formatDate = (value: string | null): string =>
    value ? new Date(value).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';

const updateStatus = (id: number, status: string): void => {
    router.patch(`/admin/pesan/${id}`, { status }, { preserveScroll: true });
};

const destroy = (id: number): void => {
    if (confirm('Hapus pesan ini?')) {
        router.delete(`/admin/pesan/${id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Pesan Masuk" />

        <div class="space-y-6">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Pesan Orang Tua</h1>
                <p class="text-sm text-gray-500 mt-1">Pesan dari formulir kontak dan permintaan kunjungan sekolah.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <Link
                    v-for="filter in filters"
                    :key="filter.id"
                    :href="filter.id ? `/admin/pesan?status=${filter.id}` : '/admin/pesan'"
                    :class="[
                        'px-4 py-2 rounded-xl text-xs font-bold border transition-colors',
                        status === filter.id
                            ? 'bg-[#006738] text-white border-[#006738]'
                            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50',
                    ]"
                >
                    {{ filter.label }}
                </Link>
            </div>

            <div v-if="messages.length === 0" class="rounded-2xl bg-white border border-gray-100 p-10 text-center">
                <span class="material-symbols-outlined text-[40px] text-gray-300">mark_email_read</span>
                <p class="text-sm text-gray-500 mt-2">Tidak ada pesan pada filter ini.</p>
            </div>

            <div v-else class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <article v-for="message in messages" :key="message.id" class="rounded-2xl bg-white border border-gray-100 p-5 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-sm font-bold text-gray-900">{{ message.nama_orang_tua }}</h2>
                            <p class="text-xs text-gray-500">{{ formatDate(message.created_at) }}</p>
                        </div>
                        <select
                            :value="message.status"
                            class="rounded-xl border-gray-200 text-xs focus:border-[#006738] focus:ring-[#006738]"
                            @change="updateStatus(message.id, ($event.target as HTMLSelectElement).value)"
                        >
                            <option value="baru">Baru</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-gray-600">
                        <p class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-[#006738]">chat</span>
                            {{ message.nomor_whatsapp }}
                        </p>
                        <p class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-[#006738]">child_care</span>
                            {{ message.nama_ananda ?? 'Belum diisi' }}
                        </p>
                        <p class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-[#006738]">school</span>
                            {{ message.program_interest ?? 'Konsultasi umum' }}
                        </p>
                        <p class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-[#006738]">calendar_month</span>
                            {{ formatDate(message.tanggal_kunjungan) }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-3 leading-relaxed">{{ message.pesan ?? 'Tidak ada catatan tambahan.' }}</p>

                    <div class="flex items-center justify-end">
                        <a
                            :href="`https://wa.me/${message.nomor_whatsapp.replace(/\D/g, '')}`"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-[#006738] text-xs font-bold hover:bg-emerald-100"
                        >
                            <span class="material-symbols-outlined text-[16px]">reply</span>
                            Balas WhatsApp
                        </a>
                        <button type="button" class="ml-1 w-8 h-8 rounded-full hover:bg-rose-50 flex items-center justify-center text-gray-500 hover:text-rose-600" title="Hapus pesan" @click="destroy(message.id)">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </article>
            </div>
        </div>
    </AdminLayout>
</template>
