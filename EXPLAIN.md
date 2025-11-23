# Penjelasan Terperinci Proyek Toko Online Laravel

## 1. Gambaran Umum Proyek
Proyek ini adalah sebuah aplikasi toko online yang dibangun menggunakan framework Laravel, bertujuan untuk memberikan kemudahan bagi pengguna dalam melakukan pembelian produk secara daring. Sistem ini mendukung berbagai peran pengguna seperti customer, admin, serta customer service (CS) dengan berbagai fitur yang terintegrasi mulai dari registrasi, pemesanan, pembayaran, hingga verifikasi pembayaran.

## 2. Arsitektur Database
Aplikasi menggunakan PostgreSQL dengan pengaturan schema ganda untuk mengoptimalkan pengelolaan data:

### 2.1 Master Schema
Schema ini bertujuan untuk menyimpan data statis dan utama seperti:
- **Users**: Data pengguna, termasuk role (customer, admin, cs1, cs2).
- **Categories**: Kategori produk.
- **Products**: Data produk yang dijual, terkait dengan kategori.

### 2.2 Transactions Schema
Schema ini mengelola data transaksi yang bersifat dinamis, antara lain:
- **Orders**: Data pesanan yang dibuat oleh customer.
- **OrderItems**: Item produk yang ada dalam setiap pesanan.
- **Payments**: Bukti pembayaran yang diupload oleh customer serta status verifikasinya.

Koneksi ke database dikonfigurasi dalam `config/database.php` dengan dua koneksi berbeda yang mengatur `search_path` ke schema yang sesuai.

## 3. Model dan Relasi Antar Model
Berikut adalah model utama beserta relasinya:

- **User**
  - Role: customer, admin, cs1, cs2.
  - Relasi: Memiliki banyak Order.
- **Category**
  - Relasi: Memiliki banyak Product.
- **Product**
  - Relasi: Berhubungan dengan Category.
- **Order**
  - Relasi: Memiliki banyak OrderItem dan satu Payment.
- **OrderItem**
  - Relasi: Berhubungan dengan satu Product.
- **Payment**
  - Relasi: Berhubungan dengan satu Order dan satu User sebagai verifier.

## 4. Alur Kerja Aplikasi
Berikut alur utama sistem:

### 4.1 Registrasi dan Login
- Pengguna baru dapat mendaftar melalui halaman `/register`.
- Pengguna harus melakukan verifikasi email untuk mengaktifkan akun.
- Autentikasi menggunakan Laravel Sanctum untuk API.

### 4.2 Manajemen Produk (Admin)
- Admin dapat mengelola data produk lewat panel admin di `/admin/products`.
- Fungsi meliputi tambah, edit, hapus produk dan import produk dari file Excel.
- Produk memiliki atribut seperti nama, kategori, deskripsi, harga, stok.

### 4.3 Browsing Produk (Customer)
- Customer dapat melihat daftar produk di halaman utama atau `/products`.
- Produk dapat difilter berdasarkan kategori.
- Detail produk dapat dilihat pada `/products/{id}`.

### 4.4 Proses Pemesanan
- Customer memilih produk dan melakukan checkout di halaman `/checkout`.
- Mengisi informasi pengiriman dan konfirmasi pesanan.
- Sistem membuat Order dengan status 'pending' di schema transaksi.
- Setiap produk dalam pesanan disimpan sebagai OrderItem.

### 4.5 Proses Pembayaran
- Setelah pesan, customer mengupload bukti pembayaran.
- Status pembayaran di-set sebagai 'uploaded'.
- Payment terkait dengan Order dan disimpan dalam schema transaksi.

### 4.6 Verifikasi Pembayaran (Customer Service)
- CS, dengan role `cs1` atau `cs2`, memverifikasi bukti pembayaran.
- Melalui halaman `/cs1` atau `/cs2`, CS dapat melihat detail pembayaran, mengubah status pembayaran menjadi 'verified' atau 'rejected', serta menambahkan catatan.
- Jika diverifikasi, status Order berubah menjadi 'confirmed' dan masuk ke tahap berikutnya.

### 4.7 Pengelolaan Pesanan Lanjutan
- Status pesanan dapat di-update (packing, shipped, completed).
- Customer dapat memantau status pesanan melalui halaman `/orders`.
- Admin dan CS juga memiliki akses untuk mengubah status pesanan.

## 5. Struktur File Utama
- **routes/**
  - `web.php` dan `auth.php` berisi definisi route aplikasi.
- **app/Http/Controllers/**
  - Berisi controller yang mengatur logika aplikasi untuk produk, order, pembayaran, profil, serta autentikasi.
- **resources/views/**
  - Template Blade yang digunakan untuk membangun UI, termasuk layout dan halaman fungsi spesifik.
- **database/migrations/**
  - File migrasi yang membuat tabel dan schema PostgreSQL.
- **database/seeders/**
  - Penambah data sample awal untuk pengguna, produk, dan kategori.

## 6. Setup dan Instalasi
Langkah untuk menjalankan proyek ini secara lokal:
1. Pasang PostgreSQL dan buat database kosong.
2. Sesuaikan konfigurasi koneksi database di `.env`.
3. Jalankan migrasi:
   ```
   php artisan migrate
   ```
4. Jalankan seeder untuk data awal:
   ```
   php artisan db:seed
   ```
5. Jalankan server:
   ```
   php artisan serve
   ```

## 7. Fitur Tambahan
- Import produk melalui file Excel untuk kemudahan upload massal.
- Middleware untuk mengontrol akses berdasarkan peran user.
- Sistem verifikasi email untuk keamanan akun.
- Upload bukti pembayaran dengan validasi status.


---

## 8. Otomatisasi Pemesanan 24 Jam

Aplikasi ini dilengkapi dengan mekanisme otomatisasi untuk mengelola pesanan yang belum dibayar oleh customer dalam waktu 24 jam. Mekanisme ini menggunakan sebuah perintah console Laravel yang berjalan secara terjadwal (scheduler), dengan detail sebagai berikut:

- Perintah console bernama `orders:cancel-unpaid` dijalankan setiap saat seperti pada scheduler harian.
- Perintah ini mencari semua pesanan dengan status `awaiting_payment` yang dibuat lebih dari 24 jam yang lalu.
- Pesanan yang memenuhi kondisi tersebut akan otomatis diubah statusnya menjadi `cancelled`.
- Dengan otomatisasi ini, sistem dapat membersihkan pesanan yang tidak dibayar secara otomatis setiap hari tanpa intervensi manual.
- Hal ini membantu menjaga database tetap bersih dan proses pemesanan berjalan lancar.

Proses otomatisasi ini biasanya diatur melalui scheduler Laravel (`app/Console/Kernel.php`) yang memanggil perintah ini sesuai jadwal waktu yang diinginkan.

---

Dokumentasi ini bertujuan agar pengembang dan pengguna memahami struktur dan alur sistem dengan jelas untuk kemudahan penggunaan dan pengembangan berkelanjutan.
