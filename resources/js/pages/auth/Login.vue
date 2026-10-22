<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { home } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const showPassword = ref(false);
</script>

<template>
    <Head title="Masuk Portal Tenaga Pendidik | TK PGRI Tamansari" />

    <div class="min-h-screen bg-[#FBFBF9] flex flex-col justify-between text-[#1A201C] font-sans antialiased selection:bg-[#E8F8F0] selection:text-[#006738]">
        <!-- Topbar Sederhana & Bersih -->
        <header class="w-full h-18 px-4 sm:px-8 bg-white/90 backdrop-blur-md border-b border-[#E8EDE9] flex items-center justify-between z-10">
            <div class="max-w-6xl mx-auto w-full flex items-center justify-between">
                <!-- Identitas Sekolah (Bukan Logo Laravel) -->
                <Link
                    :href="home.url()"
                    class="flex items-center gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006738] rounded-xl p-1"
                >
                    <div class="w-10 h-10 rounded-xl bg-[#006738] text-white flex items-center justify-center shadow-sm">
                        <!-- Custom School Cap SVG -->
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M12 3L1 9L12 15L21 10.09V17H23V9M5 13.18V17.18C5 19.94 8.13 22.18 12 22.18C15.87 22.18 19 19.94 19 17.18V13.18L12 17L5 13.18Z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="font-extrabold text-base tracking-tight text-[#1A201C] group-hover:text-[#006738] transition-colors">
                            TK PGRI Tamansari
                        </span>
                        <span class="text-xs text-[#697565] font-medium">Kota Tasikmalaya</span>
                    </div>
                </Link>

                <!-- Tombol Kembali ke Website Publik -->
                <Link
                    :href="home.url()"
                    class="inline-flex items-center gap-1.5 h-9 px-3.5 rounded-xl text-xs sm:text-sm font-semibold text-[#556358] hover:text-[#006738] hover:bg-[#F2F7F3] border border-[#E8EDE9] transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006738]"
                >
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">arrow_back</span>
                    <span>Kembali ke Website</span>
                </Link>
            </div>
        </header>

        <!-- Area Kartu Login Utama -->
        <main class="flex-1 flex flex-col justify-center items-center px-4 sm:px-6 py-8 sm:py-12">
            <div class="w-full max-w-4xl mx-auto">
                <div class="w-full bg-white rounded-3xl border border-[#E8EDE9] shadow-xl shadow-[#006738]/5 overflow-hidden flex flex-col md:flex-row">
                    
                    <!-- Sisi Kiri: Panel Info Sekolah -->
                    <div class="md:w-5/12 bg-gradient-to-br from-[#006738] via-[#145A32] to-[#0A3D20] text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
                        <!-- Hiasan Cahaya Latar -->
                        <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
                        <div class="absolute -bottom-16 -left-16 w-52 h-52 rounded-full bg-[#F5A623]/20 blur-3xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col gap-5">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-md self-start text-xs font-semibold text-emerald-100">
                                <span class="material-symbols-outlined text-[#F5A623] text-[16px]" aria-hidden="true">shield</span>
                                <span>Portal Resmi Sekolah</span>
                            </div>

                            <div class="space-y-2">
                                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight leading-snug">
                                    Panel Manajemen &amp; Tenaga Pendidik
                                </h1>
                                <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed font-normal">
                                    Akses khusus pengajar dan staf tata usaha untuk mengelola berita kegiatan, program belajar, galeri anak, serta profil resmi sekolah.
                                </p>
                            </div>

                            <!-- Fitur / Jaminan Keamanan -->
                            <div class="space-y-2.5 pt-2">
                                <div class="flex items-center gap-2.5 text-xs text-emerald-50">
                                    <span class="w-6 h-6 rounded-lg bg-white/15 flex items-center justify-center shrink-0 text-[#F5A623]">
                                        <span class="material-symbols-outlined text-[15px]" aria-hidden="true">check</span>
                                    </span>
                                    <span>Publikasi Berita &amp; Artikel Resmi</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-xs text-emerald-50">
                                    <span class="w-6 h-6 rounded-lg bg-white/15 flex items-center justify-center shrink-0 text-[#F5A623]">
                                        <span class="material-symbols-outlined text-[15px]" aria-hidden="true">check</span>
                                    </span>
                                    <span>Pembaruan Galeri Foto &amp; Kegiatan Anak</span>
                                </div>
                                <div class="flex items-center gap-2.5 text-xs text-emerald-50">
                                    <span class="w-6 h-6 rounded-lg bg-white/15 flex items-center justify-center shrink-0 text-[#F5A623]">
                                        <span class="material-symbols-outlined text-[15px]" aria-hidden="true">check</span>
                                    </span>
                                    <span>Autentikasi Terenkripsi &amp; Aman</span>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Pendidik -->
                        <div class="relative z-10 pt-6 mt-6 border-t border-white/15">
                            <p class="text-xs italic text-emerald-100 leading-relaxed">
                                “Mendidik dengan hati, membentuk karakter mulia anak usia dini dengan penuh keceriaan.”
                            </p>
                            <span class="text-xs font-bold text-[#F5A623] block mt-1.5">TK PGRI Tamansari</span>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Form Login Baru -->
                    <div class="md:w-7/12 p-8 sm:p-10 flex flex-col justify-between bg-white">
                        <div>
                            <!-- Header Form -->
                            <div class="mb-6">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-xl bg-[#E8F8F0] text-[#006738] flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[24px]" aria-hidden="true">lock_person</span>
                                    </div>
                                    <div>
                                        <h2 class="text-lg sm:text-xl font-extrabold text-[#1A201C]">Masuk ke Akun Anda</h2>
                                        <p class="text-xs text-[#697565]">Masukkan email dan kata sandi akun pendidik terdaftar</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Alert status sesi jika ada pesan dari sistem -->
                            <div v-if="status" role="status" class="mb-5 text-center text-xs font-semibold text-[#006738] bg-[#E8F8F0] p-3 rounded-xl border border-[#C2EBD4]">
                                {{ status }}
                            </div>

                            <!-- Form Autentikasi Fortify -->
                            <Form
                                v-bind="store.form()"
                                :reset-on-success="['password']"
                                v-slot="{ errors, processing }"
                                class="space-y-4"
                            >
                                <!-- Field Email -->
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-[#1A201C]" for="email">
                                        Alamat Email Resmi
                                    </label>
                                    <div class="relative flex items-center">
                                        <span class="material-symbols-outlined absolute left-3.5 text-[#889689] text-[19px] pointer-events-none" aria-hidden="true">
                                            mail
                                        </span>
                                        <input
                                            id="email"
                                            type="email"
                                            name="email"
                                            required
                                            autocomplete="email"
                                            placeholder="nama@tkpgritamansari.sch.id"
                                            class="w-full h-11 pl-10 pr-4 rounded-xl bg-[#F8FAF9] text-[#1A201C] placeholder:text-[#889689] text-xs sm:text-sm border border-[#DCE4DE] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-all"
                                        />
                                    </div>
                                    <InputError :message="errors.email" />
                                </div>

                                <!-- Field Kata Sandi -->
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex justify-between items-center">
                                        <label class="text-xs font-bold text-[#1A201C]" for="password">Kata Sandi</label>
                                        <Link
                                            v-if="canResetPassword"
                                            :href="request()"
                                            class="text-xs text-[#006738] hover:underline font-semibold focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006738] rounded"
                                        >
                                            Lupa Kata Sandi?
                                        </Link>
                                    </div>
                                    <div class="relative flex items-center">
                                        <span class="material-symbols-outlined absolute left-3.5 text-[#889689] text-[19px] pointer-events-none" aria-hidden="true">
                                            key
                                        </span>
                                        <input
                                            id="password"
                                            :type="showPassword ? 'text' : 'password'"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="••••••••••••"
                                            class="w-full h-11 pl-10 pr-10 rounded-xl bg-[#F8FAF9] text-[#1A201C] placeholder:text-[#889689] text-xs sm:text-sm border border-[#DCE4DE] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-all"
                                        />
                                        <button
                                            type="button"
                                            @click="showPassword = !showPassword"
                                            class="absolute right-3 text-[#889689] hover:text-[#1A201C] p-1 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006738]"
                                            :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                        >
                                            <span class="material-symbols-outlined text-[19px]" aria-hidden="true">
                                                {{ showPassword ? 'visibility_off' : 'visibility' }}
                                            </span>
                                        </button>
                                    </div>
                                    <InputError :message="errors.password" />
                                </div>

                                <!-- Ingat Saya -->
                                <div class="flex items-center justify-between pt-1">
                                    <label class="flex items-center gap-2 cursor-pointer select-none">
                                        <input
                                            id="remember"
                                            name="remember"
                                            type="checkbox"
                                            class="w-4 h-4 rounded text-[#006738] border-[#DCE4DE] focus:ring-[#006738] accent-[#006738] cursor-pointer"
                                        />
                                        <span class="text-xs text-[#556358]">Ingat saya di perangkat ini</span>
                                    </label>
                                    <span class="inline-flex items-center gap-1 text-xs text-[#006738] font-semibold bg-[#E8F8F0] px-2 py-0.5 rounded-md">
                                        <span class="material-symbols-outlined text-[14px]" aria-hidden="true">verified_user</span>
                                        <span>SSL Aktif</span>
                                    </span>
                                </div>

                                <!-- Tombol Masuk -->
                                <div class="pt-2">
                                    <button
                                        type="submit"
                                        :disabled="processing"
                                        class="w-full h-11 px-6 rounded-xl bg-[#006738] hover:bg-[#145A32] text-white text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-md shadow-[#006738]/20 hover:shadow-lg transition-all disabled:opacity-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006738] focus-visible:ring-offset-2 cursor-pointer"
                                    >
                                        <span v-if="processing">Memverifikasi Data...</span>
                                        <span v-else>Masuk ke Portal Pendidik</span>
                                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">login</span>
                                    </button>
                                </div>
                            </Form>

                            <!-- Bantuan Login -->
                            <div class="mt-6 p-3.5 rounded-xl bg-[#F8FAF9] border border-[#E8EDE9] flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2 text-xs text-[#556358]">
                                    <span class="material-symbols-outlined text-[#006738] text-[20px] shrink-0" aria-hidden="true">help_outline</span>
                                    <span>Lupa akun atau butuh akses baru? Hubungi admin sekolah:</span>
                                </div>
                                <a
                                    href="https://wa.me/6281223456789"
                                    target="_blank"
                                    rel="noopener"
                                    class="shrink-0 px-3 py-1 rounded-lg bg-white border border-[#DCE4DE] text-xs font-bold text-[#006738] hover:bg-[#E8F8F0] transition-colors"
                                >
                                    WhatsApp TU
                                </a>
                            </div>
                        </div>

                        <!-- Info Footer Kartu -->
                        <div class="mt-6 pt-4 border-t border-[#E8EDE9] flex items-center justify-between text-xs text-[#889689]">
                            <span>© 2024 TK PGRI Tamansari Kota Tasikmalaya</span>
                            <span class="font-medium text-[#006738]">Sistem Terpadu</span>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <!-- Footer Bawah -->
        <footer class="w-full py-4 px-4 sm:px-8 bg-white/60 border-t border-[#E8EDE9]">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-[#697565]">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#006738]"></span>
                    <span>Portal Tenaga Pendidik &amp; Administrasi Sekolah • TK PGRI Tamansari</span>
                </div>
                <div>Semua hak cipta dilindungi.</div>
            </div>
        </footer>
    </div>
</template>
