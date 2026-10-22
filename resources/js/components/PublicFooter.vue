<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { program, galeri, kontak } from '@/routes';
import { index as beritaIndex } from '@/routes/berita';

const page = usePage();
const year = computed(() => new Date().getFullYear());
const kontakInfo = computed(() => (page.props.kontak ?? {}) as Record<string, any>);
const schedules = computed(() => kontakInfo.value.jam ?? []);

const quickLinks = [
    { label: 'Program dan Kegiatan', href: program.url() },
    { label: 'Galeri Foto', href: galeri.url() },
    { label: 'Berita dan Artikel', href: beritaIndex.url() },
    { label: 'Kontak dan Kunjungan', href: kontak.url() },
];
</script>

<template>
    <footer class="w-full bg-surface border-t border-line">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12">
                <!-- About -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <span class="w-11 h-11 rounded-full bg-brand-soft text-brand-ink flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]" aria-hidden="true">school</span>
                        </span>
                        <span class="font-extrabold text-lg text-ink">TK PGRI Tamansari</span>
                    </div>
                    <p class="text-sm text-ink-muted leading-relaxed">
                        Lembaga pendidikan anak usia dini di Kecamatan Tamansari, Kota Tasikmalaya, dengan pendekatan belajar sambil bermain dan lingkungan asri yang hangat untuk anak.
                    </p>
                    <span class="inline-flex items-center gap-1.5 self-start px-3 py-1 rounded-full bg-brand-soft text-brand-on-soft text-xs font-semibold">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">groups</span>
                        Menerima usia 3 sampai 6 tahun
                    </span>
                </div>

                <!-- Contact -->
                <div class="flex flex-col gap-3">
                    <span class="font-bold text-ink text-base">Kontak &amp; Lokasi</span>
                    <div class="flex items-start gap-2 text-sm text-ink-muted">
                        <span class="material-symbols-outlined text-brand-ink text-[18px] mt-0.5 shrink-0" aria-hidden="true">location_on</span>
                        <span>{{ kontakInfo.alamat }}, {{ kontakInfo.kota }}</span>
                    </div>
                    <a :href="kontakInfo.telepon_link" class="flex items-center gap-2 text-sm text-ink-muted hover:text-brand-ink transition-colors">
                        <span class="material-symbols-outlined text-brand-ink text-[18px] shrink-0" aria-hidden="true">call</span>
                        <span>{{ kontakInfo.telepon }}</span>
                    </a>
                    <a :href="kontakInfo.whatsapp_link" target="_blank" rel="noopener" class="flex items-center gap-2 text-sm text-ink-muted hover:text-brand-ink transition-colors">
                        <span class="material-symbols-outlined text-brand-ink text-[18px] shrink-0" aria-hidden="true">chat</span>
                        <span>WhatsApp humas sekolah</span>
                    </a>
                    <a :href="`mailto:${kontakInfo.email}`" class="flex items-center gap-2 text-sm text-ink-muted hover:text-brand-ink transition-colors break-all">
                        <span class="material-symbols-outlined text-brand-ink text-[18px] shrink-0" aria-hidden="true">mail</span>
                        <span>{{ kontakInfo.email }}</span>
                    </a>
                </div>

                <!-- Opening hours -->
                <div class="flex flex-col gap-3">
                    <span class="font-bold text-ink text-base">Jam Operasional</span>
                    <dl class="flex flex-col gap-2 text-xs">
                        <div
                            v-for="row in schedules"
                            :key="row.label"
                            class="flex items-center justify-between gap-3 px-3 py-2 rounded-lg bg-surface-soft border border-line"
                        >
                            <dt class="font-medium text-ink-muted">{{ row.label }}</dt>
                            <dd :class="row.closed ? 'font-bold text-coral' : 'font-semibold text-ink'">{{ row.value }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Visit -->
                <div class="flex flex-col gap-3">
                    <span class="font-bold text-ink text-base">Kunjungi Sekolah</span>
                    <p class="text-sm text-ink-muted leading-relaxed">
                        Sesi kelas percobaan gratis dibuka pada hari kerja. Hubungi humas sekolah untuk menentukan waktu kunjungan.
                    </p>
                    <ul class="flex flex-col gap-1">
                        <li v-for="link in quickLinks" :key="link.href">
                            <Link
                                :href="link.href"
                                class="inline-flex items-center gap-1.5 min-h-9 text-sm font-semibold text-brand-ink hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface rounded"
                            >
                                {{ link.label }}
                                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">arrow_forward</span>
                            </Link>
                        </li>
                    </ul>
                    <Link
                         :href="kontak.url()"
                        class="mt-1 inline-flex items-center justify-center min-h-11 px-4 rounded-xl bg-sun text-on-sun text-sm font-bold hover:bg-sun-strong transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-focus focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
                    >
                        Jadwalkan Kunjungan
                    </Link>
                </div>
            </div>

            <div class="pt-6 border-t border-line flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-ink-subtle">
                <p>&copy; {{ year }} TK PGRI Tamansari. Hak cipta dilindungi undang-undang.</p>
                <p class="font-medium text-ink-muted">Pendidikan anak usia dini ramah anak, Kota Tasikmalaya</p>
            </div>
        </div>
    </footer>
</template>
