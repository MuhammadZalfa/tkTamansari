<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Kategori = {
    id: number;
    nama: string;
};

type Item = {
    id: number;
    galeri_kategori_id: number | null;
    title: string;
    description: string | null;
    location: string | null;
    taken_on: string | null;
    image_url: string | null;
};

const props = defineProps<{
    item: Item | null;
    kategoris: Kategori[];
}>();

const form = useForm({
    galeri_kategori_id: props.item?.galeri_kategori_id ? String(props.item.galeri_kategori_id) : '',
    title: props.item?.title ?? '',
    description: props.item?.description ?? '',
    location: props.item?.location ?? '',
    taken_on: props.item?.taken_on?.slice(0, 10) ?? '',
    image: null as File | null,
});

const setImage = (event: Event): void => {
    form.image = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const submit = (): void => {
    if (props.item) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(`/admin/galeri/${props.item.id}`, {
            forceFormData: true,
            preserveScroll: true,
        });

        return;
    }

    form.post('/admin/galeri', { forceFormData: true });
};
</script>

<template>
    <AdminLayout>
        <Head :title="item ? 'Ubah Foto Galeri' : 'Unggah Foto'" />

        <form class="space-y-6 max-w-4xl" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">{{ item ? 'Ubah Foto Galeri' : 'Unggah Foto Baru' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Foto akan tampil di halaman galeri publik.</p>
                </div>
                <div class="flex items-center gap-2">
                    <Link href="/admin/galeri" class="px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] disabled:opacity-60">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan
                    </button>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-gray-100 p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-xs font-bold text-gray-600 mb-1.5">Judul foto</label>
                        <input id="title" v-model="form.title" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        <p v-if="form.errors.title" class="text-xs text-rose-600 mt-1">{{ form.errors.title }}</p>
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-gray-600 mb-1.5">Deskripsi</label>
                        <textarea id="description" v-model="form.description" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                        <p v-if="form.errors.description" class="text-xs text-rose-600 mt-1">{{ form.errors.description }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kategori" class="block text-xs font-bold text-gray-600 mb-1.5">Kategori</label>
                            <select id="kategori" v-model="form.galeri_kategori_id" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]">
                                <option value="">Tanpa kategori</option>
                                <option v-for="kategori in kategoris" :key="kategori.id" :value="String(kategori.id)">{{ kategori.nama }}</option>
                            </select>
                            <p v-if="form.errors.galeri_kategori_id" class="text-xs text-rose-600 mt-1">{{ form.errors.galeri_kategori_id }}</p>
                        </div>
                        <div>
                            <label for="taken_on" class="block text-xs font-bold text-gray-600 mb-1.5">Tanggal foto</label>
                            <input id="taken_on" v-model="form.taken_on" type="date" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                            <p v-if="form.errors.taken_on" class="text-xs text-rose-600 mt-1">{{ form.errors.taken_on }}</p>
                        </div>
                    </div>

                    <div>
                        <label for="location" class="block text-xs font-bold text-gray-600 mb-1.5">Lokasi</label>
                        <input id="location" v-model="form.location" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Halaman sekolah" />
                        <p v-if="form.errors.location" class="text-xs text-rose-600 mt-1">{{ form.errors.location }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-bold text-gray-600">File foto</label>
                    <div v-if="item?.image_url" class="rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                        <img :src="item.image_url" :alt="item.title" class="w-full h-full object-cover" />
                    </div>
                    <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setImage" />
                    <p v-if="form.errors.image" class="text-xs text-rose-600">{{ form.errors.image }}</p>
                    <p class="text-xs text-gray-500">Format JPG, PNG, atau WEBP. Maksimal 5 MB.</p>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
