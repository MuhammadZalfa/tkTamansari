<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Misi = {
    icon: string;
    title: string;
    body: string;
};

type Fakta = {
    label: string;
    value: string;
};

type Fasilitas = {
    title: string;
    body: string;
    image: string;
    image_url?: string | null;
};

type Profil = {
    sambutan: {
        nama: string;
        nip: string;
        masa_jabatan: string;
        headline: string;
        isi: string;
        foto?: string | null;
        foto_url?: string | null;
    };
    sejarah: {
        berdiri: string;
        judul: string;
        paragraf1: string;
        paragraf2: string;
        quote: string;
        quote_credit: string;
        foto?: string | null;
        foto_url?: string | null;
    };
    visi: {
        utama: string;
        deskripsi: string;
    };
    misi: Misi[];
    fakta: Fakta[];
    fasilitas: Fasilitas[];
};

const props = defineProps<{ profil: Profil | null }>();

const form = useForm({
    sambutan: {
        nama: props.profil?.sambutan?.nama ?? '',
        nip: props.profil?.sambutan?.nip ?? '',
        masa_jabatan: props.profil?.sambutan?.masa_jabatan ?? '',
        headline: props.profil?.sambutan?.headline ?? '',
        isi: props.profil?.sambutan?.isi ?? '',
    },
    sambutan_foto: null as File | null,
    sejarah: {
        berdiri: props.profil?.sejarah?.berdiri ?? '',
        judul: props.profil?.sejarah?.judul ?? '',
        paragraf1: props.profil?.sejarah?.paragraf1 ?? '',
        paragraf2: props.profil?.sejarah?.paragraf2 ?? '',
        quote: props.profil?.sejarah?.quote ?? '',
        quote_credit: props.profil?.sejarah?.quote_credit ?? '',
    },
    sejarah_foto: null as File | null,
    visi: {
        utama: props.profil?.visi?.utama ?? '',
        deskripsi: props.profil?.visi?.deskripsi ?? '',
    },
    misi: (props.profil?.misi ?? []).map((item) => ({ icon: item.icon ?? 'auto_stories', title: item.title, body: item.body })),
    fakta: (props.profil?.fakta ?? []).map((item) => ({ label: item.label, value: item.value })),
    fasilitas: (props.profil?.fasilitas ?? []).map((item) => ({
        title: item.title,
        body: item.body,
        image: item.image ?? '',
        image_url: item.image_url ?? null,
        image_file: null as File | null,
    })),
});

const addMisi = (): void => {
    if (form.misi.length >= 8) {
        return;
    }

    form.misi.push({ icon: 'auto_stories', title: '', body: '' });
};

const addFakta = (): void => {
    if (form.fakta.length >= 8) {
        return;
    }

    form.fakta.push({ label: '', value: '' });
};

const addFasilitas = (): void => {
    if (form.fasilitas.length >= 8) {
        return;
    }

    form.fasilitas.push({ title: '', body: '', image: '', image_url: null, image_file: null });
};

const setSambutanFoto = (event: Event): void => {
    form.sambutan_foto = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const setSejarahFoto = (event: Event): void => {
    form.sejarah_foto = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const setFasilitasImage = (index: number, event: Event): void => {
    form.fasilitas[index].image_file = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const submit = (): void => {
    form.transform((data) => ({ ...data, _method: 'put' })).post('/admin/profil', {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout>
        <Head title="Profil Sekolah" />

        <form class="space-y-6 max-w-5xl" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Profil Sekolah</h1>
                    <p class="text-sm text-gray-500 mt-1">Sambutan, sejarah, visi misi, fakta singkat, dan fasilitas halaman profil.</p>
                </div>
                <button type="submit" :disabled="form.processing" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] disabled:opacity-60">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Profil
                </button>
            </div>

            <section class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                <h2 class="text-sm font-bold text-gray-900">Sambutan kepala sekolah</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama</label>
                            <input v-model="form.sambutan.nama" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                            <p v-if="form.errors['sambutan.nama']" class="text-xs text-rose-600 mt-1">{{ form.errors['sambutan.nama'] }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">NIP / NUPTK</label>
                            <input v-model="form.sambutan.nip" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Masa jabatan</label>
                            <input v-model="form.sambutan.masa_jabatan" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Judul sambutan</label>
                            <input v-model="form.sambutan.headline" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Isi sambutan</label>
                            <textarea v-model="form.sambutan.isi" rows="10" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Pisahkan paragraf dengan satu baris kosong.</p>
                            <p v-if="form.errors['sambutan.isi']" class="text-xs text-rose-600 mt-1">{{ form.errors['sambutan.isi'] }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-gray-600">Foto kepala sekolah</label>
                        <div v-if="profil?.sambutan?.foto_url" class="rounded-xl overflow-hidden bg-gray-100 aspect-[3/4]">
                            <img :src="profil.sambutan.foto_url" alt="" class="w-full h-full object-cover" />
                        </div>
                        <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setSambutanFoto" />
                        <p v-if="form.errors.sambutan_foto" class="text-xs text-rose-600">{{ form.errors.sambutan_foto }}</p>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                <h2 class="text-sm font-bold text-gray-900">Sejarah sekolah</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Tahun berdiri</label>
                                <input v-model="form.sejarah.berdiri" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Judul bagian</label>
                                <input v-model="form.sejarah.judul" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Paragraf pertama</label>
                            <textarea v-model="form.sejarah.paragraf1" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Paragraf kedua</label>
                            <textarea v-model="form.sejarah.paragraf2" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Kutipan</label>
                                <textarea v-model="form.sejarah.quote" rows="3" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Sumber kutipan</label>
                                <input v-model="form.sejarah.quote_credit" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-gray-600">Foto bangunan / suasana</label>
                        <div v-if="profil?.sejarah?.foto_url" class="rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                            <img :src="profil.sejarah.foto_url" alt="" class="w-full h-full object-cover" />
                        </div>
                        <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setSejarahFoto" />
                        <p v-if="form.errors.sejarah_foto" class="text-xs text-rose-600">{{ form.errors.sejarah_foto }}</p>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-sm font-bold text-gray-900">Visi dan misi</h2>
                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-[#006738] text-xs font-bold hover:bg-emerald-100" @click="addMisi">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        Tambah misi
                    </button>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Visi utama</label>
                    <textarea v-model="form.visi.utama" rows="3" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                    <p v-if="form.errors['visi.utama']" class="text-xs text-rose-600 mt-1">{{ form.errors['visi.utama'] }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Deskripsi visi</label>
                    <textarea v-model="form.visi.deskripsi" rows="2" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                </div>

                <div class="space-y-3">
                    <div v-for="(item, index) in form.misi" :key="index" class="rounded-xl border border-gray-200 p-4 space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs font-bold text-gray-500">Misi {{ index + 1 }}</span>
                            <button type="button" class="text-gray-500 hover:text-rose-600" title="Hapus misi" @click="form.misi.splice(index, 1)">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                            <input v-model="item.icon" type="text" class="rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Ikon" />
                            <input v-model="item.title" type="text" class="sm:col-span-3 rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Judul misi" />
                        </div>
                        <p v-if="form.errors[`misi.${index}.title`]" class="text-xs text-rose-600">{{ form.errors[`misi.${index}.title`] }}</p>
                        <textarea v-model="item.body" rows="2" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Penjelasan misi"></textarea>
                        <p v-if="form.errors[`misi.${index}.body`]" class="text-xs text-rose-600">{{ form.errors[`misi.${index}.body`] }}</p>
                    </div>
                    <p v-if="form.misi.length === 0" class="text-xs text-gray-500">Belum ada misi.</p>
                </div>
            </section>

            <section class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-sm font-bold text-gray-900">Fakta singkat</h2>
                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-[#006738] text-xs font-bold hover:bg-emerald-100" @click="addFakta">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        Tambah fakta
                    </button>
                </div>
                <div class="space-y-3">
                    <div v-for="(item, index) in form.fakta" :key="index" class="flex flex-col sm:flex-row gap-3">
                        <input v-model="item.label" type="text" class="flex-1 rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Label" />
                        <input v-model="item.value" type="text" class="flex-1 rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Nilai" />
                        <button type="button" class="text-gray-500 hover:text-rose-600 self-center" title="Hapus fakta" @click="form.fakta.splice(index, 1)">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-bold text-gray-900">Sarana dan prasarana</h2>
                        <p class="text-xs text-gray-500">Maksimal 8 fasilitas dengan foto.</p>
                    </div>
                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-[#006738] text-xs font-bold hover:bg-emerald-100" @click="addFasilitas">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        Tambah fasilitas
                    </button>
                </div>

                <div v-for="(item, index) in form.fasilitas" :key="index" class="rounded-xl border border-gray-200 p-4 grid grid-cols-1 sm:grid-cols-4 gap-3">
                    <div class="sm:col-span-3 space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs font-bold text-gray-500">Fasilitas {{ index + 1 }}</span>
                            <button type="button" class="text-gray-500 hover:text-rose-600" title="Hapus fasilitas" @click="form.fasilitas.splice(index, 1)">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                        <input v-model="item.title" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Nama fasilitas" />
                        <p v-if="form.errors[`fasilitas.${index}.title`]" class="text-xs text-rose-600">{{ form.errors[`fasilitas.${index}.title`] }}</p>
                        <textarea v-model="item.body" rows="2" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Deskripsi fasilitas"></textarea>
                        <p v-if="form.errors[`fasilitas.${index}.body`]" class="text-xs text-rose-600">{{ form.errors[`fasilitas.${index}.body`] }}</p>
                    </div>
                    <div class="space-y-2">
                        <div v-if="item.image_url" class="rounded-lg overflow-hidden bg-gray-100 aspect-[4/3]">
                            <img :src="item.image_url" alt="" class="w-full h-full object-cover" />
                        </div>
                        <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setFasilitasImage(index, $event)" />
                        <p v-if="form.errors[`fasilitas.${index}.image_file`]" class="text-xs text-rose-600">{{ form.errors[`fasilitas.${index}.image_file`] }}</p>
                    </div>
                </div>
            </section>
        </form>
    </AdminLayout>
</template>
