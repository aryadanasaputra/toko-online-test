## Fitur Utama
- Registrasi dan login pengguna dengan berbagai peran (customer, admin, cs1, cs2)
- Manajemen produk oleh admin (tambah, edit, hapus, import dari Excel)
- Proses pemesanan oleh customer dan konfirmasi melalui halaman checkout
- Upload bukti pembayaran dan verifikasi oleh customer service
- Update status pesanan mulai dari pending hingga pengiriman

## Teknologi yang Digunakan
- Laravel (PHP Framework)
- PostgreSQL dengan dua schema (master & transactions)
- Blade Templates untuk frontend
- Tailwind CSS untuk styling
- Laravel Sanctum untuk autentikasi API

## Cara Setup dan Instalasi
1. Pastikan PostgreSQL sudah terpasang dan database dibuat.
2. Sesuaikan konfigurasi database pada file `.env`.
3. Jalankan migrations:
   ```
   php artisan migrate
   ```
4. Jalankan link storage untuk data gambar:
   ```
   php artisan storage:link
   ```
5. Jalankan seeder untuk data awal:
   ```
   php artisan db:seed
   ```
6. Jalankan server lokal :
   ```
   php artisan serve -- untuk server lokal
   npm run dev -- untuk tampilan
   ```

## Struktur Folder Utama
- `app/` - Kode sumber aplikasi seperti Controllers, Models, dan Middleware.
- `routes/` - Definisi routing aplikasi.
- `resources/views/` - Template Blade untuk tampilan.
- `database/migrations/` - File migrasi database.
- `database/seeders/` - Skrip pengisian data awal.