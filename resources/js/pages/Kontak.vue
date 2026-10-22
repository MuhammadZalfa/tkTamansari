<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { home } from '@/routes';
import { store as storeKontak } from '@/routes/kontak';

const page = usePage();

const kontakInfo = computed(() => (page.props.kontak ?? {}) as Record<string, any>);

const form = useForm({
    nama_orang_tua: '',
    nomor_whatsapp: '',
    nama_ananda: '',
    program_interest: '',
    tanggal_kunjungan: '',
    pesan: '',
});

const sent = computed(() => Boolean(page.flash?.kontak_terkirim));
const minVisitDate = new Date().toISOString().slice(0, 10);

const programOptions = [
    { value: 'kb', label: 'Kelompok Bermain (KB, usia 3 - 4 tahun)' },
    { value: 'tka', label: 'TK Kelompok A (usia 4 - 5 tahun)' },
    { value: 'tkb', label: 'TK Kelompok B (usia 5 - 6 tahun)' },
    { value: 'trial', label: 'Sesi kelas percobaan gratis' },
    { value: 'umum', label: 'Konsultasi umum kurikulum dan biaya' },
];

const contactCards = computed(() => [
    {
        icon: 'chat',
        tone: 'brand',
        label: 'WhatsApp humas',
        value: kontakInfo.value.whatsapp ?? '',
        note: 'Aktif pada jam operasional sekolah untuk konsultasi program dan kunjungan sekolah.',
        href: kontakInfo.value.whatsapp_link ?? '',
        action: 'Chat WhatsApp',
        external: true,
    },
    {
        icon: 'call',
        tone: 'sky',
        label: 'Telepon sekolah',
        value: kontakInfo.value.telepon ?? '',
        note: 'Terhubung langsung ke ruang tata usaha dan kepala sekolah saat jam belajar berlangsung.',
        href: kontakInfo.value.telepon_link ?? '',
        action: 'Hubungi meja depan',
        external: false,
    },
    {
        icon: 'mail',
        tone: 'sun',
        label: 'Email korespondensi',
        value: kontakInfo.value.email ?? '',
        note: 'Ditujukan untuk kemitraan, administrasi akreditasi, dan dokumen legal.',
        href: `mailto:${kontakInfo.value.email ?? ''}`,
        action: 'Kirim email',
        external: false,
    },
    {
        icon: 'location_on',
        tone: 'coral',
        label: 'Lokasi sekolah',
        value: kontakInfo.value.alamat ?? '',
        note: kontakInfo.value.kota ?? '',
        href: kontakInfo.value.maps ?? '',
        action: 'Lihat rute peta',
        external: true,
    },
]);

const hours = computed(() => kontakInfo.value.jam ?? []);

const toneClasses = {
    brand: 'bg-brand-soft text-brand-ink',
    sky: 'bg-sky-soft text-sky',
    sun: 'bg-sun-soft text-sun-ink',
    coral: 'bg-coral-soft text-coral',
} as const;

const inputClasses =
    'w-full h-11 px-3.5 rounded-xl bg-surface text-sm text-ink placeholder:text-ink-subtle border border-line focus:outline-none focus:ring-2 focus:ring-focus';

function submit(): void {
    form.post(storeKontak.url(), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <GuestLayout>
        <Head title="Kontak dan Jadwalkan Kunjungan | TK PGRI Tamansari" />

        <div class="w-full bg-canvas">
            <!-- Header -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8">
                <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-ink-subtle mb-6">
                    <Link
                         :href="home.url()"
                        class="hover:text-brand-ink flex items-center gap-1 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-canvas rounded"
                    >
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">home</span>
                        <span>Beranda</span>
                    </Link>
                    <span aria-hidden="true">/</span>
                    <span class="text-ink font-semibold">Kontak kami</span>
                </nav>

                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-soft text-brand-on-soft text-xs font-semibold mb-3 w-fit">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">favorite</span>
                            Hubungi dan kunjungi kami
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-ink tracking-tight leading-tight">
                            Mari berkenalan lebih dekat dengan
                            <span class="text-brand-ink underline decoration-sun decoration-wavy decoration-2 underline-offset-8">TK PGRI Tamansari</span>
                        </h1>
                        <p class="mt-3 text-base sm:text-lg text-ink-muted leading-relaxed">
                            Pintu kami terbuka hangat bagi Ayah dan Bunda. Baik untuk konsultasi kurikulum maupun reservasi kunjungan langsung dan sesi kelas percobaan ramah anak.
                        </p>
                    </div>

                    <div class="flex items-center gap-4 bg-surface border border-line rounded-2xl p-4 lg:self-center shrink-0">
                        <span class="w-12 h-12 rounded-xl bg-sun-soft text-sun-ink flex items-center justify-center">
                            <span class="material-symbols-outlined text-[28px]" aria-hidden="true">door_front</span>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-ink">Kunjungan dibuka</p>
                            <p class="text-xs text-ink-muted flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-brand-ink" aria-hidden="true">check_circle</span>
                                Sesi kelas percobaan gratis pada hari kerja
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact channels -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <article
                        v-for="card in contactCards"
                        :key="card.label"
                        class="flex flex-col rounded-2xl bg-surface border border-line p-6"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-12 h-12 rounded-xl flex items-center justify-center" :class="toneClasses[card.tone as keyof typeof toneClasses]">
                                <span class="material-symbols-outlined text-[28px]" aria-hidden="true">{{ card.icon }}</span>
                            </span>
                        </div>
                        <h2 class="text-sm font-bold text-ink">{{ card.label }}</h2>
                        <p class="text-base font-bold text-brand-ink mt-1 mb-2 break-all">{{ card.value }}</p>
                        <p class="text-xs text-ink-muted mb-5 leading-relaxed">{{ card.note }}</p>
                        <a
                            :href="card.href"
                            :target="card.external ? '_blank' : undefined"
                            :rel="card.external ? 'noopener' : undefined"
                            class="mt-auto inline-flex items-center justify-center gap-2 min-h-11 px-4 rounded-xl bg-surface-soft border border-line text-xs font-semibold text-brand-ink hover:bg-brand-soft transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        >
                            {{ card.action }}
                            <span class="material-symbols-outlined text-[16px]" aria-hidden="true">{{ card.external ? 'arrow_outward' : 'arrow_forward' }}</span>
                        </a>
                    </article>
                </div>
            </section>

            <!-- Form and side info -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-7 bg-surface border border-line rounded-2xl p-6 sm:p-8">
                        <div class="mb-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sun-soft text-sun-ink text-xs font-semibold mb-2 w-fit">
                                <span class="material-symbols-outlined text-[18px]" aria-hidden="true">event_upcoming</span>
                                Layanan ramah tamu
                            </span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-ink tracking-tight mb-2">
                                Kirim pesan atau jadwalkan kunjungan
                            </h2>
                            <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">
                                Isi formulir di bawah ini dengan lengkap. Tim pengajar dan humas sekolah akan menghubungi Anda pada jam operasional.
                            </p>
                        </div>

                        <div
                            v-if="sent"
                            role="status"
                            class="mb-6 p-4 bg-brand-soft border border-line rounded-2xl flex items-start gap-3"
                        >
                            <span class="material-symbols-outlined text-brand-ink text-[24px] shrink-0" aria-hidden="true">check_circle</span>
                            <div>
                                <p class="text-sm font-bold text-brand-on-soft">Terima kasih, pesan Anda sudah terkirim</p>
                                <p class="text-xs text-ink-muted mt-1">
                                    Staf humas akan menghubungi Anda melalui nomor WhatsApp yang dicantumkan.
                                </p>
                            </div>
                        </div>

                        <form novalidate class="flex flex-col gap-4" @submit.prevent="submit">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label for="nama_orang_tua" class="text-xs font-semibold text-ink">
                                        Nama orang tua atau wali <span class="text-coral" aria-hidden="true">*</span>
                                    </label>
                                    <input
                                        id="nama_orang_tua"
                                        v-model="form.nama_orang_tua"
                                        type="text"
                                        autocomplete="name"
                                        required
                                        placeholder="Contoh: Bunda Sarah Nuraini"
                                        :class="[inputClasses, form.errors.nama_orang_tua ? 'border-coral' : '']"
                                        :aria-invalid="Boolean(form.errors.nama_orang_tua)"
                                        :aria-describedby="form.errors.nama_orang_tua ? 'error-nama_orang_tua' : undefined"
                                    />
                                    <p v-if="form.errors.nama_orang_tua" id="error-nama_orang_tua" class="text-xs text-coral">
                                        {{ form.errors.nama_orang_tua }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label for="nomor_whatsapp" class="text-xs font-semibold text-ink">
                                        Nomor WhatsApp aktif <span class="text-coral" aria-hidden="true">*</span>
                                    </label>
                                    <input
                                        id="nomor_whatsapp"
                                        v-model="form.nomor_whatsapp"
                                        type="tel"
                                        inputmode="tel"
                                        autocomplete="tel"
                                        required
                                        placeholder="0812-XXXX-XXXX"
                                        :class="[inputClasses, form.errors.nomor_whatsapp ? 'border-coral' : '']"
                                        :aria-invalid="Boolean(form.errors.nomor_whatsapp)"
                                        :aria-describedby="form.errors.nomor_whatsapp ? 'error-nomor_whatsapp' : undefined"
                                    />
                                    <p v-if="form.errors.nomor_whatsapp" id="error-nomor_whatsapp" class="text-xs text-coral">
                                        {{ form.errors.nomor_whatsapp }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label for="nama_ananda" class="text-xs font-semibold text-ink">Nama dan usia ananda</label>
                                    <input
                                        id="nama_ananda"
                                        v-model="form.nama_ananda"
                                        type="text"
                                        placeholder="Contoh: Aisyah (4 tahun)"
                                        :class="[inputClasses, form.errors.nama_ananda ? 'border-coral' : '']"
                                        :aria-invalid="Boolean(form.errors.nama_ananda)"
                                        :aria-describedby="form.errors.nama_ananda ? 'error-nama_ananda' : undefined"
                                    />
                                    <p v-if="form.errors.nama_ananda" id="error-nama_ananda" class="text-xs text-coral">
                                        {{ form.errors.nama_ananda }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label for="program_interest" class="text-xs font-semibold text-ink">
                                        Pilihan program <span class="text-coral" aria-hidden="true">*</span>
                                    </label>
                                    <select
                                        id="program_interest"
                                        v-model="form.program_interest"
                                        required
                                        :class="[inputClasses, 'cursor-pointer', form.errors.program_interest ? 'border-coral' : '']"
                                        :aria-invalid="Boolean(form.errors.program_interest)"
                                        :aria-describedby="form.errors.program_interest ? 'error-program_interest' : undefined"
                                    >
                                        <option value="" disabled>Pilih program atau layanan</option>
                                        <option v-for="option in programOptions" :key="option.value" :value="option.value">
                                            {{ option.label }}
                                        </option>
                                    </select>
                                    <p v-if="form.errors.program_interest" id="error-program_interest" class="text-xs text-coral">
                                        {{ form.errors.program_interest }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="tanggal_kunjungan" class="text-xs font-semibold text-ink">Rencana hari kunjungan</label>
                                <input
                                    id="tanggal_kunjungan"
                                    v-model="form.tanggal_kunjungan"
                                    type="date"
                                    :min="minVisitDate"
                                    :class="[inputClasses, 'cursor-pointer', form.errors.tanggal_kunjungan ? 'border-coral' : '']"
                                    :aria-invalid="Boolean(form.errors.tanggal_kunjungan)"
                                    :aria-describedby="form.errors.tanggal_kunjungan ? 'error-tanggal_kunjungan' : undefined"
                                />
                                <p v-if="form.errors.tanggal_kunjungan" id="error-tanggal_kunjungan" class="text-xs text-coral">
                                    {{ form.errors.tanggal_kunjungan }}
                                </p>
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="pesan" class="text-xs font-semibold text-ink">Pesan atau pertanyaan khusus</label>
                                <textarea
                                    id="pesan"
                                    v-model="form.pesan"
                                    rows="3"
                                    placeholder="Tuliskan pertanyaan mengenai kurikulum, jam belajar, atau hal lainnya"
                                    :class="[inputClasses, 'h-auto py-3', form.errors.pesan ? 'border-coral' : '']"
                                    :aria-invalid="Boolean(form.errors.pesan)"
                                    :aria-describedby="form.errors.pesan ? 'error-pesan' : undefined"
                                ></textarea>
                                <p v-if="form.errors.pesan" id="error-pesan" class="text-xs text-coral">
                                    {{ form.errors.pesan }}
                                </p>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="mt-2 inline-flex items-center justify-center gap-2 min-h-12 px-6 rounded-xl bg-brand text-on-brand text-sm font-bold hover:bg-brand-strong transition-colors disabled:opacity-70 disabled:cursor-not-allowed focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                            >
                                <span>{{ form.processing ? 'Mengirim pesan' : 'Kirim pesan dan ajukan kunjungan' }}</span>
                                <span
                                    class="material-symbols-outlined text-[18px]"
                                    :class="form.processing ? 'animate-spin' : ''"
                                    aria-hidden="true"
                                >
                                    {{ form.processing ? 'progress_activity' : 'send' }}
                                </span>
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-5 flex flex-col gap-6">
                        <div class="bg-surface border border-line rounded-2xl p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="w-10 h-10 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">schedule</span>
                                </span>
                                <div>
                                    <h2 class="text-sm font-bold text-ink">Jam layanan dan kunjungan</h2>
                                    <p class="text-xs text-ink-subtle">Jadwal tatap muka ramah orang tua</p>
                                </div>
                            </div>

                            <dl class="flex flex-col gap-2 text-xs">
                                <div
                                    v-for="row in hours"
                                    :key="row.label"
                                    class="flex items-center justify-between gap-3 p-3 rounded-xl bg-surface-soft border border-line"
                                >
                                    <div>
                                        <dt class="font-semibold text-ink">{{ row.label }}</dt>
                                        <dd class="text-xs text-ink-subtle">{{ row.note }}</dd>
                                    </div>
                                    <dd :class="row.closed ? 'font-bold text-coral' : 'font-bold text-brand-ink'">{{ row.value }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-surface-soft border border-line rounded-2xl p-6">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-brand-ink text-[22px]" aria-hidden="true">forum</span>
                                <h2 class="text-sm font-bold text-ink">Kotak aspirasi dan komite sekolah</h2>
                            </div>
                            <p class="text-xs text-ink-muted mb-3 leading-relaxed">
                                Bagi orang tua murid aktif yang ingin menyampaikan aspirasi atau usulan kegiatan, tersedia saluran komunikasi bersama komite TK PGRI Tamansari.
                            </p>
                            <a
                                href="mailto:komite.tkpgritamansari@gmail.com"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-ink hover:underline underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface-soft rounded"
                            >
                                <span>Hubungi pengurus komite sekolah</span>
                                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">mail</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Map -->
            <section id="peta-sekolah" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                <div class="bg-surface border border-line rounded-2xl p-6 sm:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-soft text-brand-on-soft text-xs font-semibold mb-2 w-fit">
                                <span class="material-symbols-outlined text-[18px]" aria-hidden="true">distance</span>
                                Lokasi strategis dan tenang
                            </span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-ink">Peta lokasi dan panduan rute menuju sekolah</h2>
                            <p class="text-xs sm:text-sm text-ink-muted mt-1">
                                Terletak di jalan utama Tamansari dengan suasana rindang, bebas bising jalan protokol, dan aman untuk mobilitas anak kecil.
                            </p>
                        </div>
                        <a
                            :href="kontakInfo.maps"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center justify-center gap-2 min-h-11 px-5 rounded-xl bg-brand text-on-brand text-xs font-bold hover:bg-brand-strong transition-colors shrink-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                        >
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">map</span>
                            <span>Buka di Google Maps</span>
                        </a>
                    </div>

                    <div class="relative w-full h-72 md:h-96 rounded-2xl overflow-hidden border border-line mb-6">
                        <img
                            class="w-full h-full object-cover"
                            alt="Peta lokasi TK PGRI Tamansari"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA6_mjUOlkt4oi8ceofujwaV3ESiWhA9uMojx9o0byvQrIEAvdGVoI6ecvD0P57GSonJCzcNmYsNQFi43zPbnJmv7x2qERJ4_DPuOxOpgmV5w5GGwQW9F_lSd0N9IQJRAeO_l2e_nHwi6pPVrWBNkIZR5MztsqBSAkgluNxB-scSmYGIhpr3O-iwTGxP5tUkudcg7Vk8d0AZnqu7TpyiHVQfCnq7oetS5ow_WzxS0Zk9uc5v2G3EhV5"
                        />
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-surface p-4 rounded-2xl flex items-center gap-3 max-w-sm border border-line">
                            <span class="w-12 h-12 rounded-xl bg-brand text-on-brand flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px]" aria-hidden="true">school</span>
                            </span>
                            <div>
                                <p class="flex items-center gap-1 text-sm font-bold text-ink">
                                    <span>TK PGRI Tamansari</span>
                                    <span class="material-symbols-outlined text-brand-ink text-[16px]" aria-hidden="true">verified</span>
                                </p>
                                <p class="text-xs text-ink-subtle mt-0.5">{{ kontakInfo.alamat }}, {{ kontakInfo.kota }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-surface-soft border border-line">
                            <span class="w-10 h-10 rounded-xl bg-brand-soft text-brand-ink flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">directions_bus</span>
                            </span>
                            <div>
                                <h3 class="text-xs font-bold text-ink">Akses angkutan kota</h3>
                                <p class="text-xs text-ink-muted mt-1 leading-relaxed">
                                    Angkutan trayek 07 Pancasarikan dan Tamansari berhenti tepat di seberang gerbang sekolah.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-surface-soft border border-line">
                            <span class="w-10 h-10 rounded-xl bg-sun-soft text-sun-ink flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">traffic</span>
                            </span>
                            <div>
                                <h3 class="text-xs font-bold text-ink">Jalan aspal mulus dua jalur</h3>
                                <p class="text-xs text-ink-muted mt-1 leading-relaxed">
                                    Jalan lebar dengan trotoar pedestrian aman serta area drop-off mobil yang lancar.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-surface-soft border border-line">
                            <span class="w-10 h-10 rounded-xl bg-sky-soft text-sky flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">near_me</span>
                            </span>
                            <div>
                                <h3 class="text-xs font-bold text-ink">Dekat landmark publik</h3>
                                <p class="text-xs text-ink-muted mt-1 leading-relaxed">
                                    Berdekatan dengan kantor kecamatan Tamansari dan puskesmas Tamansari.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </GuestLayout>
</template>
