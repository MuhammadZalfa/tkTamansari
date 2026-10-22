<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type BeritaRow = {
    id: number;
    slug: string;
    title: string;
    category: string;
    image_url: string | null;
    published_at: string | null;
    date_label: string | null;
};

defineProps<{ berita: BeritaRow[] }>();

const destroy = (slug: string): void => {
    if (confirm('Hapus berita ini beserta seluruh momen fotonya?')) {
        router.delete(`/admin/berita/${slug}`, { preserveScroll: true });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Kelola Berita" />

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Berita dan Artikel</h1>
                    <p class="text-sm text-gray-500 mt-1">Tulis kegiatan sekolah dan atur status terbitnya.</p>
                </div>
                <Link
                    href="/admin/berita/create"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] transition-colors"
                >
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tulis Berita
                </Link>
            </div>

            <div v-if="berita.length === 0" class="rounded-2xl bg-white border border-gray-100 p-10 text-center">
                <span class="material-symbols-outlined text-[40px] text-gray-300">newspaper</span>
                <p class="text-sm text-gray-500 mt-2">Belum ada berita. Tulis berita pertama sekolah.</p>
            </div>

            <div v-else class="rounded-2xl bg-white border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Judul</th>
                                <th class="px-5 py-3 font-semibold">Kategori</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 font-semibold">Tanggal</th>
                                <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="item in berita" :key="item.id" class="hover:bg-emerald-50/30">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3 min-w-[240px]">
                                        <span class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                            <img v-if="item.image_url" :src="item.image_url" :alt="item.title" class="w-full h-full object-cover" />
                                        </span>
                                        <span class="font-semibold text-gray-900 line-clamp-2 max-w-md">{{ item.title }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-600 whitespace-nowrap">{{ item.category }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span
                                        :class="[
                                            'inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold',
                                            item.published_at ? 'bg-emerald-100 text-[#006738]' : 'bg-amber-100 text-[#835500]',
                                        ]"
                                    >
                                        {{ item.published_at ? 'Terbit' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-500 whitespace-nowrap">{{ item.date_label ?? 'Belum terbit' }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <Link
                                            :href="`/berita/${item.slug}`"
                                            target="_blank"
                                            class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500 hover:text-[#005e90]"
                                            title="Lihat di website"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </Link>
                                        <Link
                                            :href="`/admin/berita/${item.slug}/edit`"
                                            class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500 hover:text-[#006738]"
                                            title="Ubah berita"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </Link>
                                        <button
                                            type="button"
                                            class="w-9 h-9 rounded-full hover:bg-rose-50 flex items-center justify-center text-gray-500 hover:text-rose-600"
                                            title="Hapus berita"
                                            @click="destroy(item.slug)"
                                        >
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
