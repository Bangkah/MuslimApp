# AthaQuran API  
AthaQuran API adalah layanan RESTful berbasis Laravel yang menyediakan data lengkap Al-Qur’an: daftar surah, detail surah, dan ayat-ayatnya. Proyek ini dirancang ringan, cepat, dan siap digunakan untuk aplikasi mobile, website, riset, dan sistem islami lainnya.

Menggunakan teknologi modern:  
- Laravel 12
- PHP 8.4  
- Podman/Docker container  
- Auto-import 114 surah & 6236 ayat  
- API JSON responsif  

---

##  Fitur Utama
- ✔️ Data 114 Surah lengkap  
- ✔️ Data 6236 Ayat lengkap  
- ✔️ Endpoint REST API siap pakai  
- ✔️ Command Artisan khusus (`atha:quran`)  
- ✔️ Seeder otomatis  
- ✔️ Support Podman & Docker  
- ✔️ Performa cepat & efisien  

---

## Persyaratan Sistem
- PHP 8.2+ atau melalui Podman/Docker  
- Composer  
- Laravel 11  
- MySQL/MariaDB  
- Podman atau Docker (opsi container)  

---

#  Instalasi & Setup

## 1️⃣ Clone Repository
```sh
git clone https://github.com/Bangkah/muslimApp.git
cd AthaQuran
````

## 2️⃣ Install Dependencies

```sh
composer install
```

## 3️⃣ Setup Environment

```sh
cp .env.example .env
php artisan key:generate
```

## 4️⃣ Konfigurasi Database

Edit file `.env`:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=MuslimApp
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

# Menjalankan Menggunakan Podman

## Build

```sh
podman-compose build
```

## Start

```sh
podman-compose up -d
```

## Akses aplikasi

```
http://localhost:8000
```

---

# Migrasi & Import Data Qur'an

### Jalankan migrasi:

```sh
php artisan migrate
```

### Jalankan seeder Qur'an:

```sh
php artisan db:seed --class=QuranSeeder
```

### Atau gunakan perintah custom:

```sh
php artisan atha:quran import
```

### Hapus semua data Qur'an:

```sh
php artisan atha:quran clear
```

### Informasi jumlah surah & ayat:

```sh
php artisan atha:quran info
```

---

# Endpoint API

### 1️⃣ Daftar Semua Surah

```
GET /api/surahs
```

### Contoh Response

```json
[
  {
    "id": 1,
    "name": "Al-Fatihah",
    "arabic": "ٱلْفَاتِحَة",
    "translation": "Pembukaan",
    "ayah_count": 7
  }
]
```

---

### 2️⃣ Detail Surah + Ayat

```
GET /api/surah/{id}
```

### Contoh Response

```json
{
  "surah": {
    "id": 1,
    "name": "Al-Fatihah",
    "translation": "Pembukaan",
    "arabic": "ٱلْفَاتِحَة"
  },
  "ayahs": [
    {
      "number": 1,
      "text": "بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ"
    }
  ]
}
```

---

# Testing

```sh
php artisan test
```

---

# Roadmap

* [ ] Searching ayat berbasis keyword
* [ ] Penandaan halaman Mushaf
* [ ] Streaming audio (Murattal)
* [ ] Bookmarking ayat
* [ ] Dokumentasi API otomatis (Swagger)
* [ ] Caching Redis untuk kecepatan tinggi

---

# Kontribusi

1. Fork repositori
2. Buat branch fitur:

   ```sh
   git checkout -b feature/fitur-baru
   ```
3. Commit perubahan:

   ```sh
   git commit -m "feat: menambahkan fitur X"
   ```
4. Push & buka Pull Request

---

