# Penjelasan Proyek Toko Online

## Gambaran Umum
Proyek ini adalah aplikasi toko online yang dibangun menggunakan framework Laravel. Aplikasi ini memungkinkan pengguna untuk mendaftar, login, melihat produk, melakukan pemesanan, mengunggah bukti pembayaran, dan proses verifikasi oleh customer service (CS). Data pengguna dan produk disimpan dalam schema "master", sedangkan data transaksi (pesanan, item pesanan, pembayaran) disimpan dalam schema "transactions" menggunakan PostgreSQL.

## Arsitektur Database
Aplikasi menggunakan PostgreSQL dengan dua schema utama:
- **Master Schema**: Menyimpan data pengguna (users), kategori produk (categories), dan produk (products).
- **Transactions Schema**: Menyimpan data pesanan (orders), item pesanan (order_items), dan pembayaran (payments).

Konfigurasi koneksi database didefinisikan dalam `config/database.php` dengan koneksi 'master' dan 'transactions' yang masing-masing menggunakan search_path yang sesuai.

## Model dan Relasi
### Model Utama
- **User**: Mewakili pengguna dengan peran (role) seperti customer, admin, cs1, cs2. Tersimpan di schema master.
- **Category**: Kategori produk. Tersimpan di schema master.
- **Product**: Produk yang dijual, terkait dengan kategori. Tersimpan di schema master.
- **Order**: Pesanan yang dibuat oleh pengguna. Tersimpan di schema transactions.
- **OrderItem**: Item dalam pesanan, terkait dengan produk. Tersimpan di schema transactions.
- **Payment**: Bukti pembayaran untuk pesanan, dengan status verifikasi. Tersimpan di schema transactions.

### Relasi Antar Model
- User memiliki banyak Order (one-to-many).
- Category memiliki banyak Product (one-to-many).
- Order memiliki banyak OrderItem (one-to-many) dan satu Payment (one-to-one).
- OrderItem terkait dengan satu Product.
- Payment terkait dengan satu Order dan satu User (verifier).

## Alur Kerja Aplikasi

### 1. Registrasi dan Login
- Pengguna baru dapat mendaftar melalui halaman register (`/register`).
- Setelah verifikasi email, pengguna dapat login melalui halaman login (`/login`).
- Sistem menggunakan Laravel Sanctum untuk autentikasi API.

### 2. Manajemen Produk (Admin)
- Admin dapat mengakses panel admin untuk mengelola produk.
- Halaman: `/admin/products`
- Fungsi: Tambah, edit, hapus produk, serta import produk dari file Excel.
- Produk terkait dengan kategori dan memiliki atribut seperti nama, deskripsi, harga, stok, dll.

### 3. Browsing Produk (Customer)
- Pengguna yang login sebagai customer dapat melihat daftar produk di halaman utama atau `/products`.
- Produk ditampilkan dengan filter berdasarkan kategori.
- Customer dapat melihat detail produk di `/products/{id}`.

### 4. Proses Pemesanan
- Customer memilih produk dan menambahkannya ke keranjang (jika ada fitur keranjang).
- Pada halaman checkout (`/checkout`), customer mengisi alamat pengiriman dan mengkonfirmasi pesanan.
- Sistem membuat Order baru dengan status 'pending' di schema transactions.
- OrderItem dibuat untuk setiap produk dalam pesanan.

### 5. Pembayaran
- Setelah pesanan dibuat, customer diarahkan untuk mengunggah bukti pembayaran.
- Bukti pembayaran disimpan sebagai file, dan status pembayaran diatur sebagai 'uploaded'.
- Payment terkait dengan Order dan disimpan di schema transactions.

### 6. Verifikasi Pembayaran (CS)
- Customer Service (cs1 atau cs2) dapat melihat daftar pembayaran yang perlu diverifikasi.
- Halaman: `/cs1` atau `/cs2` (tergantung role).
- CS dapat melihat detail pembayaran, mengubah status menjadi 'verified' atau 'rejected', dan menambahkan catatan.
- Jika diverifikasi, status Order diubah menjadi 'confirmed' atau status berikutnya dalam alur.

### 7. Pengelolaan Pesanan
- Setelah pembayaran diverifikasi, pesanan diproses: packing, shipped, dll.
- Customer dapat melihat status pesanan di `/orders`.
- Admin/CS dapat mengupdate status pesanan.

## Struktur File Utama
- **Routes**: Didefinisikan di `routes/web.php` dan `routes/auth.php`.
- **Controllers**: 
  - `ProductController` (admin): Mengelola CRUD produk.
  - `OrderController`: Mengelola pesanan.
  - `PaymentController`: Mengelola pembayaran.
  - `ProfileController`: Mengelola profil pengguna.
  - `Auth Controllers`: Mengelola autentikasi.
- **Views**: Blade templates di `resources/views/`, termasuk layout, form, dan halaman admin/CS.
- **Migrations**: File migrasi di `database/migrations/` untuk membuat tabel di schema yang sesuai.
- **Seeders**: `DatabaseSeeder` untuk mengisi data awal pengguna, kategori, produk, dan contoh transaksi.

## Setup dan Instalasi
1. Pastikan PostgreSQL terinstall dan database dibuat.
2. Konfigurasi `.env` dengan kredensial PostgreSQL.
3. Jalankan `php artisan migrate` untuk membuat schema dan tabel.
4. Jalankan `php artisan db:seed` untuk mengisi data awal.
5. Jalankan `php artisan serve` untuk menjalankan aplikasi.

## Fitur Tambahan
- Import produk dari Excel menggunakan `ProductsImport`.
- Middleware untuk kontrol akses berdasarkan role (`RoleMiddleware`, `DenyRoleMiddleware`).
- Email verification untuk pengguna baru.
- File upload untuk bukti pembayaran.

Aplikasi ini dirancang untuk skalabilitas dengan pemisahan schema, memungkinkan pengelolaan data yang lebih terorganisir dan performa yang optimal.
