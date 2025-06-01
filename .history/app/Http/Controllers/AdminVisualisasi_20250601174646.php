<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminVisualisasi extends Controller
{
    /**
     * Menampilkan halaman visualisasi data untuk admin.
     * Mengambil dan mengolah data dari koleksi 'data_stroke' di MongoDB
     * untuk ditampilkan dalam berbagai grafik.
     */
    public function visualisasi()
    {
        // Ambil semua data dari koleksi 'data_stroke'
        $allData = DB::connection('mongodb')->selectCollection('data_stroke')->find([])->toArray();

        // --- 1. Data untuk Distribusi Kasus Stroke (Bar Chart) ---
        $strokeCounts = [0 => 0, 1 => 0];
        foreach ($allData as $item) {
            if (isset($item->stroke)) {
                $strokeCounts[(int)$item->stroke]++;
            }
        }

        // --- 2. Data untuk Persentase Jenis Kelamin yang Berisiko Stroke (Pie Chart) ---
        // Menghitung jumlah laki-laki yang stroke dan perempuan yang stroke
        $strokeMalesCount = 0;
        $strokeFemalesCount = 0;
        foreach ($allData as $item) {
            if (isset($item->sex) && isset($item->stroke) && (int)$item->stroke === 1) {
                if ((int)$item->sex === 1) { // Laki-laki
                    $strokeMalesCount++;
                } else { // Perempuan
                    $strokeFemalesCount++;
                }
            }
        }
        $genderStrokeCounts = [
            'Laki-laki' => $strokeMalesCount,
            'Perempuan' => $strokeFemalesCount,
        ];


        // --- 3. Data untuk Tingkat Kejadian Stroke per Kelompok Usia (Line Chart) ---
        $ageBins = []; // Untuk menyimpan total pasien dan pasien stroke per kelompok usia
        $ageGroupLabels = []; // Label kelompok usia

        // Definisikan kelompok usia (misal: 18-29, 30-39, ..., 90-100)
        for ($i = 10; $i <= 100; $i += 10) { // Mulai dari 10 untuk mencakup usia muda, jika ada
            $startAge = $i;
            if ($i == 10) $startAge = 0; // Sesuaikan jika ada data usia < 10
            $endAge = $i + 9;
            if ($i == 100) $endAge = 100; // Pastikan tidak melebihi 100

            $label = ($startAge == 0) ? "<18" : "{$startAge}-{$endAge}"; // Label khusus untuk <18
            if ($startAge >= 18) { // Hanya sertakan kelompok usia 18 ke atas
                $ageGroupLabels[] = $label;
                $ageBins[$label] = ['total' => 0, 'stroke' => 0];
            }
        }
        
        // Tambahkan bin khusus untuk usia 18-29, 30-39, dst. hingga 100
        $definedAgeGroups = [];
        for ($i = 18; $i <= 90; $i += 10) {
            $label = "{$i}-" . ($i + 9);
            $definedAgeGroups[$label] = ['total' => 0, 'stroke' => 0];
        }
        $definedAgeGroups['90-100'] = ['total' => 0, 'stroke' => 0]; // Kelompok terakhir

        foreach ($allData as $item) {
            if (isset($item->age) && isset($item->stroke)) {
                $age = (int)$item->age;
                $hasStroke = (int)$item->stroke;

                foreach ($definedAgeGroups as $label => &$counts) {
                    list($start, $end) = explode('-', $label);
                    if ($age >= (int)$start && $age <= (int)$end) {
                        $counts['total']++;
                        if ($hasStroke === 1) {
                            $counts['stroke']++;
                        }
                        break; // Hentikan setelah menemukan kelompok usia yang cocok
                    }
                }
            }
        }

        $strokeIncidencePerAgeGroup = [];
        $ageGroupLabelsForChart = array_keys($definedAgeGroups);
        foreach ($definedAgeGroups as $label => $counts) {
            $incidence = ($counts['total'] > 0) ? ($counts['stroke'] / $counts['total']) * 100 : 0;
            $strokeIncidencePerAgeGroup[] = round($incidence, 2); // Persentase kejadian stroke
        }


        // --- 4. Data untuk Rata-rata BMI Pasien Stroke vs. Non-Stroke (Bar Chart) ---
        $bmiStrokeSum = 0;
        $bmiStrokeCount = 0;
        $bmiNoStrokeSum = 0;
        $bmiNoStrokeCount = 0;

        foreach ($allData as $item) {
            if (isset($item->bmi) && isset($item->stroke)) {
                $bmi = (float)$item->bmi;
                if ((int)$item->stroke === 1) {
                    $bmiStrokeSum += $bmi;
                    $bmiStrokeCount++;
                } else {
                    $bmiNoStrokeSum += $bmi;
                    $bmiNoStrokeCount++;
                }
            }
        }
        $avgBmiStroke = ($bmiStrokeCount > 0) ? round($bmiStrokeSum / $bmiStrokeCount, 2) : 0;
        $avgBmiNoStroke = ($bmiNoStrokeCount > 0) ? round($bmiNoStrokeSum / $bmiNoStrokeCount, 2) : 0;


        // --- 5. Data untuk Rata-rata BMI Berdasarkan Tipe Pekerjaan (Line Chart) ---
        $workTypeMap = [
            0 => 'Tidak Bekerja',
            1 => 'Anak-anak',
            2 => 'PNS',
            3 => 'Wiraswasta',
            4 => 'Lainnya/Tidak Diketahui', // Asumsi 4 adalah kategori lain
        ];
        $bmiPerWorkType = []; // Menyimpan total BMI dan hitungan per tipe pekerjaan

        foreach ($workTypeMap as $key => $label) {
            $bmiPerWorkType[$label] = ['sum' => 0, 'count' => 0];
        }

        foreach ($allData as $item) {
            if (isset($item->work_type) && isset($item->bmi)) {
                $workType = (int)$item->work_type;
                $bmi = (float)$item->bmi;
                $label = $workTypeMap[$workType] ?? 'Lainnya/Tidak Diketahui';

                $bmiPerWorkType[$label]['sum'] += $bmi;
                $bmiPerWorkType[$label]['count']++;
            }
        }

        $avgBmiPerWorkType = [];
        $workTypeLabels = array_values($workTypeMap); // Urutan label untuk chart
        foreach ($workTypeLabels as $label) {
            $avg = ($bmiPerWorkType[$label]['count'] > 0) ? 
                   round($bmiPerWorkType[$label]['sum'] / $bmiPerWorkType[$label]['count'], 2) : 0;
            $avgBmiPerWorkType[] = $avg;
        }


        // --- 6. Data untuk Heatmap Korelasi ---
        $numericColumns = [
            'age', 'hypertension', 'heart_disease', 'avg_glucose_level', 'bmi',
            'sex', 'ever_married', 'work_type', 'Residence_type', 'smoking_status', 'stroke'
        ];
        $matrixData = [];
        foreach ($allData as $item) {
            $row = [];
            foreach ($numericColumns as $col) {
                if (isset($item->$col)) {
                    $row[$col] = (float)$item->$col;
                } else {
                    $row[$col] = null;
                }
            }
            $matrixData[] = $row;
        }
        $correlationMatrix = $this->calculateCorrelationMatrix($matrixData, $numericColumns);


        // Mengirim semua data yang telah diolah ke view
        return view('admin.visualisasi.index', [
            'strokeCounts' => $strokeCounts,
            'genderStrokeCounts' => $genderStrokeCounts, // Data baru untuk chart 2
            'ageGroupLabelsForChart' => $ageGroupLabelsForChart, // Label untuk chart 3
            'strokeIncidencePerAgeGroup' => $strokeIncidencePerAgeGroup, // Data baru untuk chart 3
            'avgBmiStroke' => $avgBmiStroke, // Data baru untuk chart 4
            'avgBmiNoStroke' => $avgBmiNoStroke, // Data baru untuk chart 4
            'workTypeLabels' => $workTypeLabels, // Label untuk chart 5
            'avgBmiPerWorkType' => $avgBmiPerWorkType, // Data baru untuk chart 5
            'correlationMatrix' => $correlationMatrix,
            'numericColumns' => $numericColumns,
        ]);
    }

    /**
     * Menghitung koefisien korelasi Pearson antara dua array.
     * @param array $x Array data pertama
     * @param array $y Array data kedua
     * @return float|null Koefisien korelasi atau null jika tidak dapat dihitung
     */
    private function calculatePearsonCorrelation(array $x, array $y): ?float
    {
        $n = count($x);
        if ($n === 0 || $n !== count($y)) {
            return null;
        }

        $sum_x = array_sum($x);
        $sum_y = array_sum($y);
        $sum_xy = 0;
        $sum_x2 = 0;
        $sum_y2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sum_xy += $x[$i] * $y[$i];
            $sum_x2 += $x[$i] * $x[$i];
            $sum_y2 += $y[$i] * $y[$i];
        }

        $numerator = $n * $sum_xy - $sum_x * $sum_y;
        $denominator = sqrt(($n * $sum_x2 - $sum_x * $sum_x) * ($n * $sum_y2 - $sum_y * $sum_y));

        if ($denominator == 0) {
            return null;
        }

        return $numerator / $denominator;
    }

    /**
     * Menghitung matriks korelasi untuk data dan kolom yang diberikan.
     * @param array $data Array dari array asosiatif (baris data)
     * @param array $columns List kolom yang akan dihitung korelasinya
     * @return array Matriks korelasi
     */
    private function calculateCorrelationMatrix(array $data, array $columns): array
    {
        $matrix = [];
        foreach ($columns as $col1) {
            $matrix[$col1] = [];
            foreach ($columns as $col2) {
                if ($col1 === $col2) {
                    $matrix[$col1][$col2] = 1.0;
                } else {
                    $filteredX = [];
                    $filteredY = [];
                    for ($i = 0; $i < count($data); $i++) {
                        if (isset($data[$i][$col1]) && isset($data[$i][$col2])) {
                            $filteredX[] = $data[$i][$col1];
                            $filteredY[] = $data[$i][$col2];
                        }
                    }
                    $correlation = $this->calculatePearsonCorrelation($filteredX, $filteredY);
                    $matrix[$col1][$col2] = $correlation !== null ? round($correlation, 2) : 0.0;
                }
            }
        }
        return $matrix;
    }
}
