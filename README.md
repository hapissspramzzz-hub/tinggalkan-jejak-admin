# Tinggalkan Jejak - PHP + MySQL

## Struktur Folder

```text
tinggalkan-jejak/
├── index.html
├── README.md
├── api/
│   ├── register.php
│   ├── login.php
│   ├── logout.php
│   ├── jurusan.php
│   ├── cerita.php
│   └── tambah_cerita.php
├── config/
│   └── koneksi.php
├── database/
│   └── tinggalkan_jejak.sql
├── uploads/
└── assets/
    ├── css/
    └── js/
```

# Tutorial Instalasi

## 1. Install XAMPP
Jalankan Apache dan MySQL.

## 2. Pindahkan folder
Copy folder `tinggalkan-jejak` ke:

Windows:
`C:/xampp/htdocs/`

## 3. Import database
Buka phpMyAdmin:

`http://localhost/phpmyadmin`

Klik Import → pilih:

`database/tinggalkan_jejak.sql`

Klik Import.

## 4. Cek koneksi
Buka:

`http://localhost/tinggalkan-jejak/api/jurusan.php`

Jika berhasil, akan muncul data JSON.

## 5. Masukkan website utama
Copy kode HTML lama kamu ke file:

`index.html`

## 6. Tambahkan password pada form register
Tambahkan:

```html
<div class="field">
  <label>Password</label>
  <input type="password" id="reg-password" placeholder="Minimal 6 karakter">
</div>
```

## 7. Hubungkan register dengan API

```javascript
async function registerUser() {
    const response = await fetch('api/register.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            nama: document.getElementById('reg-nama').value,
            email: document.getElementById('reg-email').value,
            password: document.getElementById('reg-password').value,
            angkatan: document.getElementById('reg-angkatan').value,
            tahun_lulus: document.getElementById('reg-pondok').value
        })
    });

    const result = await response.json();
    alert(result.message);
}
```

## Catatan
Database starter ini sudah berisi beberapa contoh jurusan. Data 100 jurusan dari JavaScript dapat dimigrasikan seluruhnya ke tabel `jurusan` dan `panduan_jurusan` pada tahap berikutnya.
