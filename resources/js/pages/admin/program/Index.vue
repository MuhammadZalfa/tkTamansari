<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Program = {
    id: number;
    type: 'jenjang' | 'pilar' | 'sentra' | 'ekskul';
    name: string;
    short_name: string | null;
    age_range: string | null;
    category: string | null;
    schedule: string | null;
    sort_order: number;
    is_active: boolean;
};

const props = defineProps<{ programs: Program[] }>();

const typeLabels: Record<Program['type'], string> = {
    jenjang: 'Jenjang',
    pilar: 'Pilar karakter',
    sentra: 'Sentra',
    ekskul: 'Ekstrakurikuler',
};

const groups = computed(() =>
    (['jenjang', 'pilar', 'sentra', 'ekskul'] as Program['type'][])
        .map((type) => ({
            type,
            label: typeLabels[type],
            items: props.programs.filter((program) => program.type === type),
        }))
        .filter((group) => group.items.length > 0),
);

const destroy = (id: number): void => {
    if (confirm('Hapus program ini?')) {
        router.delete(`/admin/program/${id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Kelola Program" />

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Program dan Kegiatan</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola jenjang, pilar karakter, sentra, dan ekstrakurikuler.</p>
                </div>
                <Link
                    href="/admin/program/create"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] transition-colors"
                >
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Program
                </Link>
            </div>

            <div v-if="programs.length === 0" class="rounded-2xl bg-white border border-gray-100 p-10 text-center">
                <span class="material-symbols-outlined text-[40px] text-gray-300">event_available</span>
                <p class="text-sm text-gray-500 mt-2">Belum ada program. Tambahkan program pertama.</p>
            </div>

            <div v-for="group in groups" :key="group.type" class="rounded-2xl bg-white border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-600">{{ group.label }}</h2>
                    <span class="text-xs text-gray-500">{{ group.items.length }} item</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="item in group.items" :key="item.id" class="hover:bg-emerald-50/30">
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-gray-900">{{ item.name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ item.age_range ?? item.category ?? 'Tanpa keterangan' }}</p>
                                </td>
                                <td class="px-5 py-4 text-gray-500 whitespace-nowrap">{{ item.schedule ?? '-' }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span :class="['inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold', item.is_active ? 'bg-emerald-100 text-[#006738]' : 'bg-gray-100 text-gray-500']">
                                        {{ item.is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <Link :href="`/admin/program/${item.id}/edit`" class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500 hover:text-[#006738]" title="Ubah program">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </Link>
                                        <button type="button" class="w-9 h-9 rounded-full hover:bg-rose-50 flex items-center justify-center text-gray-500 hover:text-rose-600" title="Hapus program" @click="destroy(item.id)">
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
