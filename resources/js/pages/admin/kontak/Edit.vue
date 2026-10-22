<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Jam = {
    label: string;
    value: string;
    note: string;
    closed: boolean;
};

type Kontak = {
    telepon: string;
    telepon_link: string;
    whatsapp: string;
    whatsapp_link: string;
    email: string;
    alamat: string;
    kota: string;
    maps: string;
    jam: Jam[];
};

const props = defineProps<{ kontak: Kontak | null }>();

const form = useForm({
    telepon: props.kontak?.telepon ?? '',
    telepon_link: props.kontak?.telepon_link ?? '',
    whatsapp: props.kontak?.whatsapp ?? '',
    whatsapp_link: props.kontak?.whatsapp_link ?? '',
    email: props.kontak?.email ?? '',
    alamat: props.kontak?.alamat ?? '',
    kota: props.kontak?.kota ?? '',
    maps: props.kontak?.maps ?? '',
    jam: (props.kontak?.jam ?? [{ label: '', value: '', note: '', closed: false }]).map((row) => ({
        label: row.label,
        value: row.value,
        note: row.note,
        closed: row.closed,
    })),
});

const addJam = (): void => {
    if (form.jam.length >= 7) {
        return;
    }

    form.jam.push({ label: '', value: '', note: '', closed: false });
};

const removeJam = (index: number): void => {
    form.jam.splice(index, 1);
};

const submit = (): void => {
    form.put('/admin/kontak', { preserveScroll: true });
};
</script>

<template>
    <AdminLayout>
        <Head title="Pengaturan Kontak" />

        <form class="space-y-6 max-w-5xl" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Kontak dan Jam Operasional</h1>
                    <p class="text-sm text-gray-500 mt-1">Data ini tampil di footer, halaman kontak, dan tombol WhatsApp seluruh halaman.</p>
                </div>
                <button type="submit" :disabled="form.processing" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] disabled:opacity-60">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Kontak
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                    <h2 class="text-sm font-bold text-gray-900">Saluran komunikasi</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="telepon" class="block text-xs font-bold text-gray-600 mb-1.5">Nomor telepon</label>
                            <input id="telepon" v-model="form.telepon" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                            <p v-if="form.errors.telepon" class="text-xs text-rose-600 mt-1">{{ form.errors.telepon }}</p>
                        </div>
                        <div>
                            <label for="telepon_link" class="block text-xs font-bold text-gray-600 mb-1.5">Tautan telepon</label>
                            <input id="telepon_link" v-model="form.telepon_link" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="tel:02653456789" />
                            <p v-if="form.errors.telepon_link" class="text-xs text-rose-600 mt-1">{{ form.errors.telepon_link }}</p>
                        </div>
                        <div>
                            <label for="whatsapp" class="block text-xs font-bold text-gray-600 mb-1.5">Nomor WhatsApp</label>
                            <input id="whatsapp" v-model="form.whatsapp" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                            <p v-if="form.errors.whatsapp" class="text-xs text-rose-600 mt-1">{{ form.errors.whatsapp }}</p>
                        </div>
                        <div>
                            <label for="whatsapp_link" class="block text-xs font-bold text-gray-600 mb-1.5">Tautan WhatsApp</label>
                            <input id="whatsapp_link" v-model="form.whatsapp_link" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="https://wa.me/628..." />
                            <p v-if="form.errors.whatsapp_link" class="text-xs text-rose-600 mt-1">{{ form.errors.whatsapp_link }}</p>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-600 mb-1.5">Email</label>
                        <input id="email" v-model="form.email" type="email" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1">{{ form.errors.email }}</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                    <h2 class="text-sm font-bold text-gray-900">Alamat dan peta</h2>

                    <div>
                        <label for="alamat" class="block text-xs font-bold text-gray-600 mb-1.5">Alamat</label>
                        <input id="alamat" v-model="form.alamat" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        <p v-if="form.errors.alamat" class="text-xs text-rose-600 mt-1">{{ form.errors.alamat }}</p>
                    </div>
                    <div>
                        <label for="kota" class="block text-xs font-bold text-gray-600 mb-1.5">Kota dan kode pos</label>
                        <input id="kota" v-model="form.kota" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        <p v-if="form.errors.kota" class="text-xs text-rose-600 mt-1">{{ form.errors.kota }}</p>
                    </div>
                    <div>
                        <label for="maps" class="block text-xs font-bold text-gray-600 mb-1.5">Tautan Google Maps</label>
                        <input id="maps" v-model="form.maps" type="url" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        <p v-if="form.errors.maps" class="text-xs text-rose-600 mt-1">{{ form.errors.maps }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-bold text-gray-900">Jam operasional</h2>
                        <p class="text-xs text-gray-500">Tampil di footer dan kartu kontak publik.</p>
                    </div>
                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-[#006738] text-xs font-bold hover:bg-emerald-100" @click="addJam">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        Tambah baris
                    </button>
                </div>

                <div v-for="(row, index) in form.jam" :key="index" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-start border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                    <div class="sm:col-span-4">
                        <input v-model="row.label" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Senin - Kamis" />
                        <p v-if="form.errors[`jam.${index}.label`]" class="text-xs text-rose-600 mt-1">{{ form.errors[`jam.${index}.label`] }}</p>
                    </div>
                    <div class="sm:col-span-3">
                        <input v-model="row.value" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="07.30 - 11.30 WIB" />
                        <p v-if="form.errors[`jam.${index}.value`]" class="text-xs text-rose-600 mt-1">{{ form.errors[`jam.${index}.value`] }}</p>
                    </div>
                    <div class="sm:col-span-3">
                        <input v-model="row.note" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Catatan" />
                    </div>
                    <div class="sm:col-span-2 flex items-center justify-between gap-2 pt-2">
                        <label class="flex items-center gap-1.5 text-xs text-gray-600">
                            <input v-model="row.closed" type="checkbox" class="rounded border-gray-300 text-[#006738] focus:ring-[#006738]" />
                            Tutup
                        </label>
                        <button type="button" class="text-gray-500 hover:text-rose-600" title="Hapus baris" @click="removeJam(index)">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
