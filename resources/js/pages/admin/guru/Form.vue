<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Teacher = {
    id: number;
    name: string;
    role: string;
    focus: string | null;
    points: string[] | null;
    nuptk: string | null;
    education: string | null;
    photo_url: string | null;
    sort_order: number;
    is_active: boolean;
};

const props = defineProps<{ teacher: Teacher | null }>();

const form = useForm({
    name: props.teacher?.name ?? '',
    role: props.teacher?.role ?? '',
    focus: props.teacher?.focus ?? '',
    points: (props.teacher?.points ?? []).join('\n'),
    nuptk: props.teacher?.nuptk ?? '',
    education: props.teacher?.education ?? '',
    photo: null as File | null,
    sort_order: props.teacher?.sort_order ?? 0,
    is_active: props.teacher?.is_active ?? true,
});

const setPhoto = (event: Event): void => {
    form.photo = (event.target as HTMLInputElement).files?.[0] ?? null;
};

const submit = (): void => {
    if (props.teacher) {
        form.transform((data) => ({ ...data, _method: 'put' })).post(`/admin/guru/${props.teacher.id}`, {
            forceFormData: true,
            preserveScroll: true,
        });

        return;
    }

    form.post('/admin/guru', { forceFormData: true });
};
</script>

<template>
    <AdminLayout>
        <Head :title="teacher ? 'Ubah Data Pendidik' : 'Tambah Pendidik'" />

        <form class="space-y-6 max-w-4xl" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">{{ teacher ? 'Ubah Data Pendidik' : 'Tambah Pendidik' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Isi fokus peran agar tampil di bagian Peran Pendidik halaman profil.</p>
                </div>
                <div class="flex items-center gap-2">
                    <Link href="/admin/guru" class="px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] disabled:opacity-60">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-4 rounded-2xl bg-white border border-gray-100 p-6">
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-600 mb-1.5">Nama lengkap</label>
                        <input id="name" v-model="form.name" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        <p v-if="form.errors.name" class="text-xs text-rose-600 mt-1">{{ form.errors.name }}</p>
                    </div>
                    <div>
                        <label for="role" class="block text-xs font-bold text-gray-600 mb-1.5">Peran</label>
                        <input id="role" v-model="form.role" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Wali Kelas TK-A & Sentra Seni" />
                        <p v-if="form.errors.role" class="text-xs text-rose-600 mt-1">{{ form.errors.role }}</p>
                    </div>
                    <div>
                        <label for="focus" class="block text-xs font-bold text-gray-600 mb-1.5">Fokus peran (publik)</label>
                        <textarea id="focus" v-model="form.focus" rows="3" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Kosongkan jika bukan peran pendamping kelas."></textarea>
                        <p class="text-xs text-gray-500 mt-1">Hanya pendidik dengan fokus terisi yang tampil di halaman profil publik.</p>
                        <p v-if="form.errors.focus" class="text-xs text-rose-600 mt-1">{{ form.errors.focus }}</p>
                    </div>
                    <div>
                        <label for="points" class="block text-xs font-bold text-gray-600 mb-1.5">Poin tugas</label>
                        <textarea id="points" v-model="form.points" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Satu poin per baris"></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nuptk" class="block text-xs font-bold text-gray-600 mb-1.5">NUPTK / keterangan</label>
                            <input id="nuptk" v-model="form.nuptk" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                        <div>
                            <label for="education" class="block text-xs font-bold text-gray-600 mb-1.5">Pendidikan</label>
                            <input id="education" v-model="form.education" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                        <div>
                            <label for="sort_order" class="block text-xs font-bold text-gray-600 mb-1.5">Urutan tampil</label>
                            <input id="sort_order" v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                        </div>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-[#006738] focus:ring-[#006738]" />
                            Aktif
                        </label>
                    </div>

                    <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-3">
                        <h2 class="text-sm font-bold text-gray-900">Foto</h2>
                        <div v-if="teacher?.photo_url" class="w-24 h-24 rounded-full overflow-hidden bg-gray-100">
                            <img :src="teacher.photo_url" :alt="teacher.name" class="w-full h-full object-cover" />
                        </div>
                        <input type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-[#006738] file:font-semibold" @change="setPhoto" />
                        <p v-if="form.errors.photo" class="text-xs text-rose-600">{{ form.errors.photo }}</p>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
