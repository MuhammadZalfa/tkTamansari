<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Teacher = {
    id: number;
    name: string;
    role: string;
    focus: string | null;
    nuptk: string | null;
    education: string | null;
    photo_url: string | null;
    is_active: boolean;
    sort_order: number;
};

defineProps<{ teachers: Teacher[] }>();

const destroy = (id: number): void => {
    if (confirm('Hapus data pendidik ini?')) {
        router.delete(`/admin/guru/${id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Kelola Guru dan Tendik" />

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Guru dan Tenaga Kependidikan</h1>
                    <p class="text-sm text-gray-500 mt-1">Nama dan NUPTK hanya terlihat di portal admin, tidak di website publik.</p>
                </div>
                <Link href="/admin/guru/create" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    Tambah Pendidik
                </Link>
            </div>

            <div v-if="teachers.length === 0" class="rounded-2xl bg-white border border-gray-100 p-10 text-center">
                <span class="material-symbols-outlined text-[40px] text-gray-300">groups</span>
                <p class="text-sm text-gray-500 mt-2">Belum ada data pendidik.</p>
            </div>

            <div v-else class="rounded-2xl bg-white border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Pendidik</th>
                                <th class="px-5 py-3 font-semibold">Peran</th>
                                <th class="px-5 py-3 font-semibold">NUPTK</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="item in teachers" :key="item.id" class="hover:bg-emerald-50/30">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3 min-w-[220px]">
                                        <span class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 shrink-0">
                                            <img v-if="item.photo_url" :src="item.photo_url" :alt="item.name" class="w-full h-full object-cover" />
                                        </span>
                                        <span>
                                            <span class="block font-semibold text-gray-900">{{ item.name }}</span>
                                            <span class="block text-xs text-gray-500">{{ item.education ?? '-' }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-600 max-w-xs">{{ item.role }}</td>
                                <td class="px-5 py-4 text-gray-500 whitespace-nowrap">{{ item.nuptk ?? '-' }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span :class="['inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold', item.is_active ? 'bg-emerald-100 text-[#006738]' : 'bg-gray-100 text-gray-500']">
                                        {{ item.is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <Link :href="`/admin/guru/${item.id}/edit`" class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500 hover:text-[#006738]" title="Ubah data">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </Link>
                                        <button type="button" class="w-9 h-9 rounded-full hover:bg-rose-50 flex items-center justify-center text-gray-500 hover:text-rose-600" title="Hapus data" @click="destroy(item.id)">
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
