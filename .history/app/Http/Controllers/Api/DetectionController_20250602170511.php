```php
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DetectionController extends Controller
{
    public function getDetectionsPerMonth(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|string',
        ]);

        $userId = $request->input('user_id');

        try {
            // Inisialisasi array untuk menyimpan jumlah deteksi per bulan (1-12)
            $deteksisPerMonthArray = array_fill(1, 12, 0);

            // Ambil data deteksi per bulan dari MongoDB
            $deteksisPerMonth = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->aggregate([
                    [
                        '$match' => [
                            'user_id' => (string)$userId,
                        ],
                    ],
                    [
                        // Potong created_at untuk mengambil hanya 3 digit milidetik dan tambahkan Z
                        '$addFields' => [
                            'created_at_trimmed' => [
                                '$concat' => [
                                    ['$substrCP' => ['$created_at', 0, 23]],
                                    'Z'
                                ]
                            ]
                        ],
                    ],
                    [
                        // Konversi created_at_trimmed ke tanggal
                        '$addFields' => [
                            'created_at_date' => [
                                '$dateFromString' => [
                                    'dateString' => '$created_at_trimmed',
                                    'format' => '%Y-%m-%dT%H:%M:%S.%LZ',
                                    'onError' => null,
                                    'onNull' => null,
                                ],
                            ],
                        ],
                    ],
                    [
                        // Ambil data deteksi per bulan
                        '$group' => [
                            '_id' => ['$month' => '$created_at_date'],
                            'count' => ['$sum' => 1],
                        ],
                    ],
                    ['$sort' => ['_id' => 1]],
                ]);

            $deteksisPerMonthArrayRaw = iterator_to_array($deteksisPerMonth);
            Log::info('Deteksis Per Month Raw Result for User ' . $userId . ':', $deteksisPerMonthArrayRaw);

            foreach ($deteksisPerMonthArrayRaw as $data) {
                $monthIndex = $data['_id'];
                if ($monthIndex >= 1 && $monthIndex <= 12) {
                    $deteksisPerMonthArray[$monthIndex] = $data['count'];
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $deteksisPerMonthArray,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error Fetching Deteksi Data for User ' . $userId . ': ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data deteksi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
```

### Catatan Penting
- **Namespace**: Namespace diubah menjadi `App\Http\Controllers\Api` untuk mencerminkan lokasi folder `Api`.
- **Struktur Response**: API mengembalikan data dalam format `{"status": "success", "data": {"1": 5, "2": 10, ...}}`, yang sesuai dengan kode Flutter yang Anda gunakan sebelumnya.
- **Error Handling**: Kode mencakup penanganan error dan logging untuk memudahkan debugging.

4. **Daftarkan Route di Laravel**
   - Buka file `routes/api.php` dan tambahkan rute untuk endpoint baru:
     ```php
     use App\Http\Controllers\Api\DetectionController;

     Route::post('/deteksi_per_bulan', [DetectionController::class, 'getDetectionsPerMonth']);
     ```
   - Endpoint ini akan dapat diakses di `http://127.0.0.1:8000/api/deteksi_per_bulan` (sesuaikan dengan domain server Anda).

5. **Integrasi dengan Kode Flutter**
   - Kode Flutter Anda sebelumnya sudah menggunakan endpoint `http://127.0.0.1:8000/api/deteksi_per_bulan` di fungsi `_fetchDetectionData`. Pastikan URL di kode Flutter sesuai dengan server Laravel Anda (misalnya, ganti `127.0.0.1:8000` jika server berjalan di domain lain, seperti saat deployment).
   - Pastikan `user_id` yang dikirim dari Flutter sesuai dengan format yang diharapkan oleh API (string).

6. **Uji API**
   - Jalankan server Laravel dengan:
     ```bash
     php artisan serve
     ```
   - Uji endpoint menggunakan alat seperti Postman atau cURL:
     ```bash
     curl -X POST http://127.0.0.1:8000/api/deteksi_per_bulan -d "user_id=123"
     ```
   - Pastikan MongoDB berjalan dan koleksi `hasil_deteksi` berisi data dengan format yang sesuai (field `user_id` dan `created_at`).

7. **Perbarui Kode Flutter (Jika Perlu)**
   - Kode Flutter Anda di `_fetchDetectionData` sudah sesuai dengan format response API di atas. Namun, untuk memastikan kompatibilitas, periksa bahwa data diparse dengan benar:
     ```dart
     Future<void> _fetchDetectionData() async {
       if (_userId == null) return;
       try {
         final response = await http.post(
           Uri.parse('http://127.0.0.1:8000/api/deteksi_per_bulan'),
           body: {'user_id': _userId},
         );
         if (response.statusCode == 200) {
           final Map<String, dynamic> data = jsonDecode(response.body)['data'];
           setState(() {
             detectionData = {
               for (var entry in data.entries) int.parse(entry.key): entry.value
             };
           });
         } else {
           print('Gagal mengambil data deteksi: ${response.statusCode}');
         }
       } catch (e) {
         print('Error fetching detection data: $e');
       }
     }
     ```
   - Pastikan `_userId` diambil dengan benar dari `SharedPreferences` seperti di `_loadUserData`.

### Struktur Direktori
Setelah langkah-langkah di atas, struktur direktori Anda akan terlihat seperti ini:
```
app/
└── Http/
    └── Controllers/
        └── Api/
            └── DetectionController.php
```

### Potensi Masalah dan Solusi
- **MongoDB Tidak Tersambung**: Pastikan konfigurasi MongoDB di `config/database.php` benar dan MongoDB server berjalan.
- **Format created_at Bermasalah**: Jika format `created_at` di `hasil_deteksi` tidak sesuai, sesuaikan pipeline agregasi di `getDetectionsPerMonth` berdasarkan format sebenarnya.
- **API Tidak Dapat Diakses dari Flutter**: Periksa apakah server Laravel berjalan di `127.0.0.1:8000`. Untuk emulator Android, gunakan `10.0.2.2:8000` jika server berjalan di localhost. Untuk deployment, gunakan domain publik.
- **Data Tidak Muncul di Grafik**: Log data response dari API di Flutter (`print(jsonDecode(response.body))`) untuk memastikan formatnya sesuai.

### Langkah Selanjutnya
- Uji API dan integrasi dengan Flutter menggunakan data pengguna yang valid.
- Jika Anda ingin menambahkan fitur lain, seperti filter tahun untuk grafik atau visualisasi tambahan, beri tahu saya.
- Jika ada error spesifik saat menjalankan kode, bagikan pesan errornya untuk analisis lebih lanjut.

Apakah Anda perlu bantuan dengan konfigurasi MongoDB, route tambahan, atau penyesuaian lain di kode Flutter atau Laravel?