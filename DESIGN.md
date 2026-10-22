# DESIGN.md — TK PGRI Tamansari

Arah desain untuk website publik TK PGRI Tamansari. Dokumen ini adalah **data arah**, bukan instruksi. Filter anti-slop diterapkan di atasnya.

Dokumen ini disusun dari identitas yang sudah ada di website (dipilih pemilik proyek), bukan dari pilihan agen.

---

## 1. Identitas

TK PGRI Tamansari adalah taman kanak-kanak di Kecamatan Tamansari, Kota Tasikmalaya. Audience utama: orang tua anak usia 3-6 tahun yang mencari tempat belajar aman, hangat, dan menggembirakan. Pengunjung kedua: calon murid baru yang sedang membandingkan sekolah.

Nada: hangat, ramah anak, tetapi tetap resmi karena educate untuk orang tua, bukan untuk anak yang membaca sendiri.

**Design Read:** *halaman sekolah PAUD publik untuk orang tua anak usia 3-6 tahun, bahasa visual hangat-asri Indonesia, dial ENERGY 2 / RHYTHM 2 / MOTION 1.*

| Dial | Nilai | Artinya untuk halaman ini |
|---|---|---|
| ENERGY | 2 | Ramah tapi tidak ramai. Hijau brand sebagai warna utama, amber sebagai satu aksen. Tidak ada gradient ungu, glow, atau dekorasi berlapis. |
| RHYTHM | 2 | Komposisi antar seksi bervariasi: hero split, daftar editorial, grid kartu, band berwarna, blok berita asimetris, band CTA. Tidak semua seksi "judul tengah + grid kartu". |
| MOTION | 1 | Hanya transisi warna/elevasi saat hover dan fokus. Tidak ada scale, translate, bounce, atau animasi masuk. |

## 2. Palet

Inti 2 warna + 1 aksen + netral (R-29).

| Peran | Token | Terang | Gelap | Alasan |
|---|---|---|---|---|
| Hijau brand | `brand` | `#006738` | `#1E824C` | Warna yayasan/sekolah yang sudah dipakai, jadi identitas bukan pilihan agen. Dipakai untuk CTA utama dan penanda aktif. |
| Hijau tua | `brand-strong` | `#004F29` | `#15603A` | State hover CTA dan latar band hijau tua. |
| Hijau teks | `brand-ink` | `#006738` | `#6FD9A0` | Hijau untuk teks dan ikon di atas netral. Rasio kontras minimal 7:1 di kedua tema. |
| Hijau lembut | `brand-soft` | `#E8F5ED` | `#16281C` | Latar badge, ikon tile, dan baris info. |
| Aksen amber | `sun` | `#F5A623` | `#F5A623` | Satu-satunya aksen. Dipakai untuk CTA utama dan sorotan, tidak pernah untuk teks kecil. |
| Amber teks | `sun-ink` | `#8A5200` | `#F0B357` | Amber asli hanya reaches 2:1 di atas putih, jadi teks amber memakai versi gelap. |
| Biru | `sky` | `#005E90` | `#7FC4F0` | Warna kedua untuk topik non-utama (fasilitas, outdoors, pengumuman). |
| Merah | `coral` | `#B3261E` | `#F09187` | Hanya untuk kondisi khusus (jam tutup, info penting). |
| Kanvas | `canvas` | `#FBFBF9` | `#111814` | Latar halaman, hangat di terang dan hijau-keabu di gelap. |
| Permukaan | `surface` | `#FFFFFF` | `#18201B` | Kartu dan panel. |
| Teks | `ink` / `ink-muted` / `ink-subtle` | `#16201B` / `#4A5550` / `#5F6B64` | Tiga tingkat hierarki teks, semua lolos WCAG AA. |
| Garis | `line` / `line-strong` | `#E3E7E2` / `#CBD3CC` | Pemisah, bukan bayangan. |

Semua nilai token ada di `resources/css/app.css` dan punya pasangan terang/gelap. Warna hex tidak boleh ditulis langsung di halaman (R-29, R-31).

## 3. Tipografi

`Plus Jakarta Sans` untuk seluruh tampilan.

Alasan: huruf sans geometris yang membulat, terbaca jelas di ukuran kecil, dan membawa kesan ramah tanpa menjadi seperti aplikasi anak. Dipasang dengan bobot berbeda (extrabold untuk judul, semibold untuk subjudul, regular untuk isi). Mono, uppercase besar, dan font display bergaya terminal tidak dipakai karena halaman ini dibaca orang tua, bukan developer.

Skala: judul halaman `text-3xl` sampai `text-5xl`, judul seksi `text-2xl` sampai `text-3xl`, judul kartu `text-base` sampai `text-xl`, body `text-sm` sampai `text-base`, caption `text-xs`. Tidak ada teks di bawah 12px (R-25, tap target).

## 4. Radius, bayangan, dan gerak

| Elemen | Radius | Alasan |
|---|---|---|
| Kartu, panel besar | `rounded-2xl` (16px) | Radius besar yang hangat tanpa membuat semua elemen jadi pil. |
| Tombol, input, tile ikon | `rounded-xl` (12px) | Hierarki radius yang jelas: elemen makin kecil, radius makin kecil. |
| Label kecil (chip, badge) | `rounded-full` | Pil hanya untuk label ringkas, bukan untuk semua elemen (R-11). |
| Ikon bulat (logo, avatar) | `rounded-full` | Bentuk lingkaran punya makna (logo, foto orang). |

Bayangan hanya pada elemen yang benar-benar terangkat: header lengket, dropdown, lightbox. Kartu biasa memakai garis, bukan bayangan (R-12).

Gerak: hanya `transition-colors` dan `transition-shadow` pada hover/fokus. Tanpa `hover:scale`, tanpa `hover:-translate-y`, tanpa `animate-ping` (R-19, MOTION 1).

## 5. Komposisi

- Satu titik fokus per layar: judul besar + satu CTA utama di hero; setiap seksi lain punya satu CTA yang spesifik.
- Whitespace sebagai struktur: jarak seksi `py-14 lg:py-20`, jarak kartu `gap-6`.
- Satu aksen (amber) dipakai pada momen penting: CTA utama hero, penanda fokus, dan penekanan satu kata pada judul. Tidak di semua tombol.
- Motif identitas: garis bawah bergelombang amber pada kata kunci di judul, dipakai konsisten di Beranda, Profil, Kontak, dan Galeri.

## 6. Aturan konten (bukan sekadar visual)

Halaman tidak boleh memuat angka prestasi, testimoni, nama orang, atau tautan yang tidak punya sumber nyata (R-17, R-18, R-38).

- Angka untuk program (jam belajar, rasio guru kelas, usia anak) boleh ditampilkan karena itu parameter operasional kelas, bukan klaim prestasi.
- Statistik prestasi ("500+ alumni", "26+ tahun", "98% puas") tidak ditampilkan sampai ada sumber resmi dari sekolah.
- Testimoni orang tua tidak ditampilkan sampai ada kutipan asli beserta nama dan foto nyata.
- Dataomsday profil pendidik ditampilkan sebagai peran dan fokus kerja, bukan nama dan foto rekaan.
- Tahun ajaran dan tanggal agenda ditulis sebagai siklus (bulan tanpa tahun, atau "setiap tahun") supaya tidak basi, atau diisi dengan tahun yang benar oleh pemilik.
- Formulir harus benar-benar terkirim ke server, bukan hanya berubah state di browser (R-26).

## 7. Yang sengaja dihindari

Gradien ungu-biru, glow, blob dekoratif blur, grid dekoratif, badge pil di atas H1, tombol generik ("Learn More", "Explore"), statistik rekaan, testimoni rekaan, ikon bintang/kilau sebagai ikon fitur, dan animasi masuk berulang.
