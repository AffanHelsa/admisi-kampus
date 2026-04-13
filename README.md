# Admisi Kampus — Tugas Week 4 Public API

Aplikasi monolith berbasis Laravel untuk sistem informasi admisi kampus
yang mengintegrasikan Hipolabs Public API sebagai sumber data universitas.

## Public API yang Digunakan
- **Nama:** Hipolabs Universities API
- **Base URL:** `http://universities.hipolabs.com`
- **Autentikasi:** Tidak diperlukan (free, no API key)
- **Dokumentasi:** https://github.com/Hipo/university-domains-list

## Endpoint

| Method | Endpoint | Fungsi |
|--------|----------|--------|
| GET | /api/universities/search | Ambil daftar universitas dari Hipolabs Public API |
| GET | /api/registrations | Ambil semua data pendaftaran |
| POST | /api/registrations | Buat pendaftaran baru |
| PUT | /api/registrations/{id} | Update status pendaftaran |
| DELETE | /api/registrations/{id} | Hapus pendaftaran |

## Teknologi
- PHP 8.2
- Laravel 12
- MySQL
- Hipolabs Public API

## Cara Menjalankan

```bash
git clone https://github.com/AffanHelsa/admisi-kampus.git
cd admisi-kampus
composer install
cp .env.example .env
php artisan key:generate
# Sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD di file .env
php artisan migrate
php artisan serve
```

## Postman Collection
Import file `Admisi Kampus API.postman_collection.json` di Postman
untuk langsung mencoba semua endpoint.
