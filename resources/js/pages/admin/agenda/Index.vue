<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Agenda = {
    id: number;
    semester: 'ganjil' | 'genap';
    month: string;
    title: string;
    body: string;
    focus: string | null;
    sort_order: number;
    is_active: boolean;
};

defineProps<{ agendas: Agenda[] }>();

const destroy = (id: number): void => {
    if (confirm('Hapus agenda ini?')) {
        router.delete(`/admin/agenda/${id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Kelola Agenda" />

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Agenda Tahunan</h1>
                    <p class="text-sm text-gray-500 mt-1">Kegiatan semester ganjil dan genap yang tampil di halaman program.</p>
                </div>
                <Link href="/admin/agenda/create" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Agenda
                </Link>
            </div>

            <div v-if="agendas.length === 0" class="rounded-2xl bg-white border border-gray-100 p-10 text-center">
                <span class="material-symbols-outlined text-[40px] text-gray-300">calendar_month</span>
                <p class="text-sm text-gray-500 mt-2">Belum ada agenda.</p>
            </div>

            <div v-else class="rounded-2xl bg-white border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Bulan</th>
                                <th class="px-5 py-3 font-semibold">Kegiatan</th>
                                <th class="px-5 py-3 font-semibold">Semester</th>
                                <th class="px-5 py-3 font-semibold">Fokus</th>
                                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="item in agendas" :key="item.id" class="hover:bg-emerald-50/30">
                                <td class="px-5 py-4 font-semibold text-gray-900 whitespace-nowrap">{{ item.month }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-gray-900">{{ item.title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-1 max-w-md">{{ item.body }}</p>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-[#006738] capitalize">{{ item.semester }}</span>
                                </td>
                                <td class="px-5 py-4 text-gray-500 max-w-xs">{{ item.focus ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <Link :href="`/admin/agenda/${item.id}/edit`" class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500 hover:text-[#006738]" title="Ubah agenda">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </Link>
                                        <button type="button" class="w-9 h-9 rounded-full hover:bg-rose-50 flex items-center justify-center text-gray-500 hover:text-rose-600" title="Hapus agenda" @click="destroy(item.id)">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
