
# MuslimApp API

REST API Laravel untuk menampilkan data Al-Qur'an, termasuk surah, ayat, dan fitur pencarian.  
Dibuat dengan Laravel 12 dan MariaDB/MySQL.

---

## Persyaratan

- PHP >= 8.1  
- Composer  
- MySQL/MariaDB  
- Laravel 12.x  
- Postman (untuk testing API)

---

##  Instalasi

1. **Clone repository**
```bash
git clone https://github.com/Bangkah/muslimApp.git
cd muslimApp
````

2. **Install dependencies**

```bash
composer install
```

3. **Buat file `.env`**

```bash
cp .env.example .env
```

Sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=muslimApp
DB_USERNAME=root
DB_PASSWORD=
```

4. **Generate key aplikasi**

```bash
php artisan key:generate
```

5. **Jalankan migrasi dan seeder**

```bash
php artisan migrate
php artisan db:seed --class=SurahSeeder
php artisan db:seed --class=AyahSeeder
php artisan db:seed --class=QuranSeeder
```

6. **Jalankan server**

```bash
php artisan serve
```

Server berjalan di: `http://127.0.0.1:8000`

---

##  API Endpoints

### Surah

* **GET /api/surahs**
  Menampilkan daftar semua surah.
  **Contoh response:**

```json
{
  "success": true,
  "message": "Daftar surah berhasil diambil.",
  "data": [
    {
      "id": 1,
      "number": 1,
      "name": "الفاتحة",
      "name_latin": "Al-Fatihah",
      "number_of_ayah": 7
    }
  ]
}
```

* **GET /api/surah/{id}**
  Menampilkan detail surah beserta semua ayat.
  **Contoh response:**

```json
{
  "success": true,
  "message": "Detail surah berhasil diambil.",
  "data": {
    "id": 1,
    "number": 1,
    "name": "الفاتحة",
    "ayahs": [
      {
        "id": 1,
        "ayah_number": 1,
        "text_arab": "بسم الله الرحمن الرحيم",
        "translation_id": "Dengan nama Allah Yang Maha Pengasih"
      }
    ]
  }
}
```

### Ayah

* **GET /api/ayahs**
  Menampilkan semua ayat beserta surah terkait.
  ⚠️ Untuk data besar, gunakan pagination atau limit untuk menghindari memory error.

* **GET /api/ayah/{id}**
  Menampilkan detail ayat tertentu.

### Al-Qur'an

* **GET /api/quran**
  Menampilkan seluruh data Al-Qur'an (surah, ayat, arab, terjemahan, tafsir).

### Pencarian

* **GET /api/search?q={kata}**
  Mencari kata di ayat atau data Quran.
  Contoh: `/api/search?q=Allah`
  **Contoh response:**

```json
{
  "success": true,
  "message": "Hasil pencarian ayat.",
  "data": {
    "ayah": [
      {
        "id": 1,
        "ayah_number": 1,
        "text_arab": "بسم الله الرحمن الرحيم",
        "translation_id": "Dengan nama Allah Yang Maha Pengasih"
      }
    ],
    "quran": [
      {
        "id": 1,
        "surah": 1,
        "ayah": 1,
        "arabic": "بسم الله الرحمن الرحيم",
        "translation_id": "Dengan nama Allah Yang Maha Pengasih",
        "tafsir": "Ayat pembuka Al-Fatihah"
      }
    ]
  }
}
```

---

## Tips Penggunaan

* Gunakan **limit** atau **pagination** pada endpoint `/api/ayahs` untuk mencegah memory error:

```php
Ayah::with('surah')->orderBy('id')->paginate(100);
```

* Pastikan tabel sudah diisi data sebelum mencoba endpoint `/api/search`.
* Gunakan Postman untuk testing endpoint.

---


## Catatan

Project ini dibuat untuk **edukasi** dan belajar membuat REST API Laravel. <br>
Data Al-Qur'an dapat diisi melalui seeder atau impor dari file JSON.
