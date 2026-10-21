# Tinggalkan Jejak

Aplikasi PHP dan MySQL untuk berbagi cerita mahasiswa dengan moderasi admin.

## Persyaratan

- PHP 8.1+ dengan `mysqli` aktif
- MySQL 8+ atau MariaDB yang mendukung InnoDB dan `utf8mb4`
- Apache atau web server PHP lain
- HTTPS untuk deployment publik

## Instalasi lokal (Laragon)

1. Letakkan folder proyek di `C:\laragon\www\tinggalkan-jejak-admin` lalu jalankan Apache dan MySQL.
2. Buat database kosong bernama `tinggalkan_jejak` di phpMyAdmin, lalu impor `tinggalkan_jejak.sql`. Dump ini berisi skema dan data referensi yang digunakan aplikasi. Jangan impor ke database yang berisi data penting tanpa backup terlebih dahulu.
3. Secara bawaan koneksi memakai `127.0.0.1`, database `tinggalkan_jejak`, user `root`, dan password kosong. Atur `DB_HOST`, `DB_NAME`, `DB_USER`, dan `DB_PASS` di environment bila nilai tersebut berbeda.
4. Atur environment `ADMIN_PASSWORD` ke kata sandi acak minimal 16 karakter sebelum menjalankan Apache. Di Windows, set sebagai System environment variable, lalu tutup dan buka kembali Laragon agar Apache mewarisinya.
5. Buka halaman utama melalui Laragon virtual host atau `http://localhost/tinggalkan-jejak-admin/`. Panel admin ada di `/admin.html`.

## Fitur

- Pendaftaran dan login email/password dengan password hash dan sesi server
- Profil pengguna, termasuk ubah profil dan hapus akun
- Pengiriman cerita untuk antrean moderasi
- Cerita yang disetujui admin langsung tampil di bagian Komunitas; cerita yang ditolak tetap terlihat di riwayat pemilik
- Panel admin dengan pencarian, filter jurusan, statistik, setujui, tolak, dan hapus
- Bagian Pembelajaran berisi mata pelajaran, topik, dan materi ringkas
- Pencatatan pengunjung unik dan kunjungan harian

Pengguna perlu mendaftar atau masuk untuk mengirim cerita. Admin meninjau cerita di panel `/admin.html`; pilih **Setujui** untuk menerbitkannya. Cerita tanpa jurusan tampil di bagian Komunitas, sedangkan cerita yang memilih jurusan tampil pada balok jurusan yang sesuai. Untuk database yang sudah ada dari versi sebelumnya, jalankan migrasi berikut satu kali:

```sql
ALTER TABLE cerita ADD COLUMN jurusan_nama VARCHAR(150) NULL AFTER jurusan_id;
```

Navigasi **Komunitas** dan **Pembelajaran** tersedia di bagian atas beranda.

## Deployment publik

1. Buat database baru, impor SQL, lalu atur kredensial `DB_*` pada environment PHP.
2. Set `ADMIN_PASSWORD` yang kuat pada environment layanan web dan restart PHP/Apache.
3. Sajikan situs hanya melalui HTTPS. Pastikan direktori `config/` tidak dapat diakses langsung dari web; jangan unggah file dump SQL ke document root publik pada hosting yang tidak memblokir file `.sql`.
4. Batasi akses phpMyAdmin dan akun MySQL. Gunakan akun aplikasi dengan hak minimum pada database aplikasi, bukan akun root.
5. Uji pendaftaran, login, pengiriman cerita, moderasi, dan penghapusan data pada staging sebelum membuka situs untuk umum.

Foto profil disimpan sebagai data URL pada kolom `users.foto`; batas ukuran unggahan sebaiknya dibatasi di browser/server.