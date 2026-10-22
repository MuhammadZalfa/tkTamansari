<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Moment = {
    title: string;
    note: string | null;
    image: string;
    image_url: string | null;
};

type Berita = {
    id: number;
    slug: string;
    title: string;
    category: string;
    excerpt: string;
    body: string;
    image: string | null;
    image_url: string | null;
    image_alt: string | null;
    image_caption: string | null;
    quote: string | null;
    quote_attribution: string | null;
    tags: string[] | null;
    published_at: string | null;
    moments: Moment[];
};

const props = defineProps<{ berita: Berita | null }>();

const form = useForm({
    title: props.berita?.title ?? '',
    category: props.berita?.category ?? '',
    excerpt: props.berita?.excerpt ?? '',
    body: props.berita?.body ?? '',
    image: null as File | null,
    image_alt: props.berita?.image_alt ?? '',
    image_caption: props.berita?.image_caption ?? '',
    quote: props.berita?.quote ?? '',
    quote_attribution: props.berita?.quote_attribution ?? '',
    tags: (props.berita?.tags ?? []).join(', '),
    published: Boolean(props.berita?.published_at),
    moments: (props.berita?.moments ?? []).map((moment) => ({
        title: moment.title,
        note: moment.note ?? '',
        existing_image: moment.image,
        existing_image_url: moment.image_url,
        image: null as File | null,
    })),
});

const addMoment = (): void => {
    if (form.moments.length >= 6) {
        return;
    }

    form.moments.push({ title: '', note: '', existing_image: '', existing_image_url: null, image: null });
};

const removeMoment = (index: number): void => {
    form.moments.splice(index, 1);
};

const setImage = (event: Event): void => {
    form.image = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const setMomentImage = (index: number, event: Event): void => {
    form.moments[index].image = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const submit = (): void => {
    if (props.berita) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(`/admin/berita/${props.berita.slug}`, {
            forceFormData: true,
            preserveScroll: true,
        });

        return;
    }

    form.post('/admin/berita', { forceFormData: true });
};
</script>

<template>
    <AdminLayout>
        <Head :title="berita ? 'Ubah Berita' : 'Tulis Berita'" />

        <form class="space-y-6" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">{{ berita ? 'Ubah Berita' : 'Tulis Berita Baru' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi informasi kegiatan, lalu pilih apakah langsung diterbitkan.</p>
                </div>
                <div class="flex items-center gap-2">
                    <Link href="/admin/berita" class="px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] disabled:opacity-60"
                    >
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Berita
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 space-y-6">
                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <div>
                            <label for="title" class="block text-xs font-bold text-gray-600 mb-1.5">Judul berita</label>
                            <input id="title" v-model="form.title" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Contoh: Parade busana adat Nusantara" />
                            <p v-if="form.errors.title" class="text-xs text-rose-600 mt-1">{{ form.errors.title }}</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="category" class="block text-xs font-bold text-gray-600 mb-1.5">Kategori</label>
                                <input id="category" v-model="form.category" list="kategori-berita" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Kegiatan siswa" />
                                <datalist id="kategori-berita">
                                    <option value="Kegiatan siswa" />
                                    <option value="Pengumuman" />
                                    <option value="Edukasi" />
                                    <option value="Prestasi" />
                                    <option value="Parenting" />
                                </datalist>
                                <p v-if="form.errors.category" class="text-xs text-rose-600 mt-1">{{ form.errors.category }}</p>
                            </div>
                            <div>
                                <label for="tags" class="block text-xs font-bold text-gray-600 mb-1.5">Tag</label>
                                <input id="tags" v-model="form.tags" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Hari Kartini, Pentas seni" />
                                <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma.</p>
                                <p v-if="form.errors.tags" class="text-xs text-rose-600 mt-1">{{ form.errors.tags }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="excerpt" class="block text-xs font-bold text-gray-600 mb-1.5">Ringkasan</label>
                            <textarea id="excerpt" v-model="form.excerpt" rows="3" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Ringkasan singkat yang tampil di daftar berita."></textarea>
                            <p v-if="form.errors.excerpt" class="text-xs text-rose-600 mt-1">{{ form.errors.excerpt }}</p>
                        </div>

                        <div>
                            <label for="body" class="block text-xs font-bold text-gray-600 mb-1.5">Isi berita</label>
                            <textarea id="body" v-model="form.body" rows="12" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Pisahkan paragraf dengan satu baris kosong."></textarea>
                            <p class="text-xs text-gray-500 mt-1">Pisahkan paragraf dengan satu baris kosong.</p>
                            <p v-if="form.errors.body" class="text-xs text-rose-600 mt-1">{{ form.errors.body }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-sm font-bold text-gray-900">Galeri momen</h2>
                                <p class="text-xs text-gray-500">Maksimal 6 foto pendukung, masing-masing dengan judul.</p>
                            </div>
                            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-[#006738] text-xs font-bold hover:bg-emerald-100" @click="addMoment">
                                <span class="material-symbols-outlined text-[16px]">add</span>
                                Tambah
                            </button>
                        </div>

                        <div v-if="form.moments.length === 0" class="text-xs text-gray-500 py-3">Belum ada momen tambahan.</div>

                        <div v-for="(moment, index) in form.moments" :key="index" class="rounded-xl border border-gray-200 p-4 space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-xs font-bold text-gray-500">Momen {{ index + 1 }}</span>
                                <button type="button" class="text-gray-500 hover:text-rose-600" title="Hapus momen" @click="removeMoment(index)">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <input v-model="moment.title" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Judul momen" />
                                    <p v-if="form.errors[`moments.${index}.title`]" class="text-xs text-rose-600 mt-1">{{ form.errors[`moments.${index}.title`] }}</p>
                                </div>
                                <div>
                                    <input v-model="moment.note" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Keterangan singkat" />
                                    <p v-if="form.errors[`moments.${index}.note`]" class="text-xs text-rose-600 mt-1">{{ form.errors[`moments.${index}.note`] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span v-if="moment.existing_image_url" class="w-14 h-14 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                    <img :src="moment.existing_image_url" alt="" class="w-full h-full object-cover" />
                                </span>
                                <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setMomentImage(index, $event)" />
                            </div>
                            <p v-if="form.errors[`moments.${index}.image`]" class="text-xs text-rose-600">{{ form.errors[`moments.${index}.image`] }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <h2 class="text-sm font-bold text-gray-900">Status publikasi</h2>
                        <label class="flex items-start gap-3 rounded-xl bg-gray-50 p-3 cursor-pointer">
                            <input v-model="form.published" type="checkbox" class="mt-0.5 rounded border-gray-300 text-[#006738] focus:ring-[#006738]" />
                            <span>
                                <span class="block text-xs font-bold text-gray-800">Terbitkan di website</span>
                                <span class="block text-xs text-gray-500">Jika tidak dicentang, berita disimpan sebagai draft.</span>
                            </span>
                        </label>
                    </div>

                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <h2 class="text-sm font-bold text-gray-900">Foto utama</h2>
                        <div v-if="berita?.image_url" class="rounded-xl overflow-hidden bg-gray-100 aspect-video">
                            <img :src="berita.image_url" :alt="berita.image_alt ?? berita.title" class="w-full h-full object-cover" />
                        </div>
                        <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setImage" />
                        <p v-if="form.errors.image" class="text-xs text-rose-600">{{ form.errors.image }}</p>

                        <div>
                            <label for="image_alt" class="block text-xs font-bold text-gray-600 mb-1.5">Teks alternatif</label>
                            <input id="image_alt" v-model="form.image_alt" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                        <div>
                            <label for="image_caption" class="block text-xs font-bold text-gray-600 mb-1.5">Keterangan foto</label>
                            <input id="image_caption" v-model="form.image_caption" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <h2 class="text-sm font-bold text-gray-900">Kutipan</h2>
                        <div>
                            <textarea v-model="form.quote" rows="3" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Kutipan inspirasional (opsional)"></textarea>
                            <p v-if="form.errors.quote" class="text-xs text-rose-600 mt-1">{{ form.errors.quote }}</p>
                        </div>
                        <div>
                            <label for="quote_attribution" class="block text-xs font-bold text-gray-600 mb-1.5">Sumber kutipan</label>
                            <input id="quote_attribution" v-model="form.quote_attribution" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
