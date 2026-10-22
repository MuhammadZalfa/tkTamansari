<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Program = {
    id: number;
    type: 'jenjang' | 'pilar' | 'sentra' | 'ekskul';
    name: string;
    short_name: string | null;
    age_range: string | null;
    category: string | null;
    summary: string | null;
    points: string[] | null;
    schedule: string | null;
    time: string | null;
    ratio: string | null;
    icon: string | null;
    image_url: string | null;
    sort_order: number;
    is_active: boolean;
};

const props = defineProps<{ program: Program | null }>();

const form = useForm({
    type: props.program?.type ?? 'jenjang',
    name: props.program?.name ?? '',
    short_name: props.program?.short_name ?? '',
    age_range: props.program?.age_range ?? '',
    category: props.program?.category ?? '',
    summary: props.program?.summary ?? '',
    points: (props.program?.points ?? []).join('\n'),
    schedule: props.program?.schedule ?? '',
    time: props.program?.time ?? '',
    ratio: props.program?.ratio ?? '',
    icon: props.program?.icon ?? '',
    image: null as File | null,
    sort_order: props.program?.sort_order ?? 0,
    is_active: props.program?.is_active ?? true,
});

const setImage = (event: Event): void => {
    form.image = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const submit = (): void => {
    if (props.program) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(`/admin/program/${props.program.id}`, {
            forceFormData: true,
            preserveScroll: true,
        });

        return;
    }

    form.post('/admin/program', { forceFormData: true });
};
</script>

<template>
    <AdminLayout>
        <Head :title="program ? 'Ubah Program' : 'Tambah Program'" />

        <form class="space-y-6 max-w-5xl" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">{{ program ? 'Ubah Program' : 'Tambah Program' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Jenjang tampil di beranda, pilar dan agenda di halaman program.</p>
                </div>
                <div class="flex items-center gap-2">
                    <Link href="/admin/program" class="px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] disabled:opacity-60">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="type" class="block text-xs font-bold text-gray-600 mb-1.5">Jenis program</label>
                                <select id="type" v-model="form.type" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]">
                                    <option value="jenjang">Jenjang (KB, TK-A, TK-B)</option>
                                    <option value="pilar">Pilar karakter</option>
                                    <option value="sentra">Sentra pembelajaran</option>
                                    <option value="ekskul">Ekstrakurikuler</option>
                                </select>
                                <p v-if="form.errors.type" class="text-xs text-rose-600 mt-1">{{ form.errors.type }}</p>
                            </div>
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-600 mb-1.5">Nama program</label>
                                <input id="name" v-model="form.name" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                                <p v-if="form.errors.name" class="text-xs text-rose-600 mt-1">{{ form.errors.name }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="summary" class="block text-xs font-bold text-gray-600 mb-1.5">Ringkasan</label>
                            <textarea id="summary" v-model="form.summary" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                            <p v-if="form.errors.summary" class="text-xs text-rose-600 mt-1">{{ form.errors.summary }}</p>
                        </div>

                        <div>
                            <label for="points" class="block text-xs font-bold text-gray-600 mb-1.5">Poin penting</label>
                            <textarea id="points" v-model="form.points" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Satu poin per baris"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Satu poin per baris.</p>
                            <p v-if="form.errors.points" class="text-xs text-rose-600 mt-1">{{ form.errors.points }}</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="schedule" class="block text-xs font-bold text-gray-600 mb-1.5">Jadwal</label>
                                <input id="schedule" v-model="form.schedule" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Senin - Jumat" />
                            </div>
                            <div>
                                <label for="time" class="block text-xs font-bold text-gray-600 mb-1.5">Waktu</label>
                                <input id="time" v-model="form.time" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="07.30 - 11.30 WIB" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="short_name" class="block text-xs font-bold text-gray-600 mb-1.5">Nama pendek</label>
                                <input id="short_name" v-model="form.short_name" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="TK-A" />
                            </div>
                            <div>
                                <label for="age_range" class="block text-xs font-bold text-gray-600 mb-1.5">Rentang usia</label>
                                <input id="age_range" v-model="form.age_range" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Usia 4 - 5 tahun" />
                            </div>
                            <div>
                                <label for="ratio" class="block text-xs font-bold text-gray-600 mb-1.5">Rasio guru</label>
                                <input id="ratio" v-model="form.ratio" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="1 guru : 12 anak" />
                            </div>
                        </div>

                        <div>
                            <label for="category" class="block text-xs font-bold text-gray-600 mb-1.5">Kategori pilar</label>
                            <input id="category" v-model="form.category" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Spiritual dan adab" />
                            <p v-if="form.errors.category" class="text-xs text-rose-600 mt-1">{{ form.errors.category }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <div>
                            <label for="icon" class="block text-xs font-bold text-gray-600 mb-1.5">Ikon Material Symbols</label>
                            <input id="icon" v-model="form.icon" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="school" />
                        </div>
                        <div>
                            <label for="sort_order" class="block text-xs font-bold text-gray-600 mb-1.5">Urutan tampil</label>
                            <input id="sort_order" v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-[#006738] focus:ring-[#006738]" />
                            Aktif dan tampil di website
                        </label>
                    </div>

                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-3">
                        <h2 class="text-sm font-bold text-gray-900">Foto program</h2>
                        <div v-if="program?.image_url" class="rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                            <img :src="program.image_url" :alt="program.name" class="w-full h-full object-cover" />
                        </div>
                        <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setImage" />
                        <p v-if="form.errors.image" class="text-xs text-rose-600">{{ form.errors.image }}</p>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
