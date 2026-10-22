<script setup lang="ts">
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Kategori = {
    id: number;
    nama: string;
    slug: string;
};

type Item = {
    id: number;
    title: string;
    description: string | null;
    image_url: string | null;
    date_label: string | null;
    location: string | null;
    kategori: { nama: string } | null;
};

defineProps<{
    items: Item[];
    kategoris: Kategori[];
}>();

const kategoriForm = useForm({ nama: '' });

const addKategori = (): void => {
    kategoriForm.post('/admin/galeri/kategori', {
        preserveScroll: true,
        onSuccess: () => kategoriForm.reset(),
    });
};

const destroyKategori = (id: number): void => {
    if (confirm('Hapus kategori ini? Foto di dalamnya tetap tersimpan tanpa kategori.')) {
        router.delete(`/admin/galeri/kategori/${id}`, { preserveScroll: true });
    }
};

const destroyItem = (id: number): void => {
    if (confirm('Hapus foto ini dari galeri?')) {
        router.delete(`/admin/galeri/${id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Kelola Galeri" />

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Galeri Kegiatan</h1>
                    <p class="text-sm text-gray-500 mt-1">Dokumentasi kegiatan sekolah dan kategori albumnya.</p>
                </div>
                <Link
                    href="/admin/galeri/create"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] transition-colors"
                >
                    <span class="material-symbols-outlined text-[18px]">add_photo_alternate</span>
                    Unggah Foto
                </Link>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 space-y-4">
                    <div v-if="items.length === 0" class="rounded-2xl bg-white border border-gray-100 p-10 text-center">
                        <span class="material-symbols-outlined text-[40px] text-gray-300">photo_library</span>
                        <p class="text-sm text-gray-500 mt-2">Belum ada foto. Unggah dokumentasi pertama.</p>
                    </div>

                    <div v-else class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <article v-for="item in items" :key="item.id" class="rounded-2xl bg-white border border-gray-100 overflow-hidden">
                            <div class="aspect-[4/3] bg-gray-100">
                                <img v-if="item.image_url" :src="item.image_url" :alt="item.title" class="w-full h-full object-cover" />
                            </div>
                            <div class="p-4 space-y-2">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-bold text-[#006738]">{{ item.kategori?.nama ?? 'Tanpa kategori' }}</span>
                                    <span class="text-xs text-gray-500">{{ item.date_label }}</span>
                                </div>
                                <h2 class="text-sm font-bold text-gray-900 line-clamp-2">{{ item.title }}</h2>
                                <p v-if="item.location" class="text-xs text-gray-500 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ item.location }}
                                </p>
                                <div class="flex items-center gap-1 pt-1">
                                    <Link :href="`/admin/galeri/${item.id}/edit`" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500 hover:text-[#006738]" title="Ubah foto">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </Link>
                                    <button type="button" class="w-8 h-8 rounded-full hover:bg-rose-50 flex items-center justify-center text-gray-500 hover:text-rose-600" title="Hapus foto" @click="destroyItem(item.id)">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4 self-start">
                    <div>
                        <h2 class="text-sm font-bold text-gray-900">Kategori galeri</h2>
                        <p class="text-xs text-gray-500">Dipakai sebagai filter di halaman publik.</p>
                    </div>

                    <form class="flex gap-2" @submit.prevent="addKategori">
                        <input v-model="kategoriForm.nama" type="text" class="flex-1 rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Nama kategori baru" />
                        <button type="submit" :disabled="kategoriForm.processing" class="px-3 py-2 rounded-xl bg-[#006738] text-white text-xs font-bold hover:bg-[#145A32] disabled:opacity-60">
                            Tambah
                        </button>
                    </form>
                    <p v-if="kategoriForm.errors.nama" class="text-xs text-rose-600">{{ kategoriForm.errors.nama }}</p>

                    <ul class="divide-y divide-gray-50">
                        <li v-for="kategori in kategoris" :key="kategori.id" class="flex items-center justify-between gap-2 py-2.5">
                            <span class="text-sm text-gray-700">{{ kategori.nama }}</span>
                            <button type="button" class="text-gray-500 hover:text-rose-600" title="Hapus kategori" @click="destroyKategori(kategori.id)">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </li>
                        <li v-if="kategoris.length === 0" class="py-2.5 text-xs text-gray-500">Belum ada kategori.</li>
                    </ul>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
