<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';

type Agenda = {
    id: number;
    semester: 'ganjil' | 'genap';
    month: string;
    title: string;
    body: string;
    focus: string | null;
    icon: string | null;
    sort_order: number;
    is_active: boolean;
};

const props = defineProps<{ agenda: Agenda | null }>();

const form = useForm({
    semester: props.agenda?.semester ?? 'ganjil',
    month: props.agenda?.month ?? '',
    title: props.agenda?.title ?? '',
    body: props.agenda?.body ?? '',
    focus: props.agenda?.focus ?? '',
    icon: props.agenda?.icon ?? '',
    sort_order: props.agenda?.sort_order ?? 0,
    is_active: props.agenda?.is_active ?? true,
});

const submit = (): void => {
    if (props.agenda) {
        form.put(`/admin/agenda/${props.agenda.id}`, { preserveScroll: true });

        return;
    }

    form.post('/admin/agenda');
};
</script>

<template>
    <AdminLayout>
        <Head :title="agenda ? 'Ubah Agenda' : 'Tambah Agenda'" />

        <form class="space-y-6 max-w-3xl" @submit.prevent="submit">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">{{ agenda ? 'Ubah Agenda' : 'Tambah Agenda' }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Agenda ditampilkan pada tab semester di halaman program.</p>
                </div>
                <div class="flex items-center gap-2">
                    <Link href="/admin/agenda" class="px-4 py-2.5 rounded-xl bg-white border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#006738] text-white text-sm font-bold hover:bg-[#145A32] disabled:opacity-60">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan
                    </button>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-gray-100 p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="semester" class="block text-xs font-bold text-gray-600 mb-1.5">Semester</label>
                        <select id="semester" v-model="form.semester" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]">
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                        <p v-if="form.errors.semester" class="text-xs text-rose-600 mt-1">{{ form.errors.semester }}</p>
                    </div>
                    <div>
                        <label for="month" class="block text-xs font-bold text-gray-600 mb-1.5">Bulan</label>
                        <input id="month" v-model="form.month" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Juli" />
                        <p v-if="form.errors.month" class="text-xs text-rose-600 mt-1">{{ form.errors.month }}</p>
                    </div>
                </div>

                <div>
                    <label for="title" class="block text-xs font-bold text-gray-600 mb-1.5">Nama kegiatan</label>
                    <input id="title" v-model="form.title" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                    <p v-if="form.errors.title" class="text-xs text-rose-600 mt-1">{{ form.errors.title }}</p>
                </div>

                <div>
                    <label for="body" class="block text-xs font-bold text-gray-600 mb-1.5">Deskripsi</label>
                    <textarea id="body" v-model="form.body" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]"></textarea>
                    <p v-if="form.errors.body" class="text-xs text-rose-600 mt-1">{{ form.errors.body }}</p>
                </div>

                <div>
                    <label for="focus" class="block text-xs font-bold text-gray-600 mb-1.5">Fokus pembelajaran</label>
                    <input id="focus" v-model="form.focus" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="Adaptasi emosional dan kawan baru" />
                    <p v-if="form.errors.focus" class="text-xs text-rose-600 mt-1">{{ form.errors.focus }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="icon" class="block text-xs font-bold text-gray-600 mb-1.5">Ikon</label>
                        <input id="icon" v-model="form.icon" type="text" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" placeholder="celebration" />
                    </div>
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-gray-600 mb-1.5">Urutan</label>
                        <input id="sort_order" v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-[#006738] focus:ring-[#006738]" />
                    </div>
                    <label class="flex items-center gap-2 text-sm text-gray-700 pt-6">
                        <input v-model="form.is_active" type="checkbox" class="rounded border-gray-300 text-[#006738] focus:ring-[#006738]" />
                        Aktif
                    </label>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
