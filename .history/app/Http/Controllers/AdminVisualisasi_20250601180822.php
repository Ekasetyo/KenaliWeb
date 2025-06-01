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
        $strokeCounts = [0 => 0, 1 => 0]; // 0: Tidak Stroke, 1: Stroke
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
                if ((int)$item->sex === 1) { // 1: Laki-laki
                    $strokeMalesCount++;
                } else { // 0: Perempuan
                    $strokeFemalesCount++;
                }
            }
        }
        $genderStrokeCounts = [
            'Laki-laki Stroke' => $strokeMalesCount,
            'Perempuan Stroke' => $strokeFemalesCount,
        ];


        // --- 3. Data untuk Tingkat Kejadian Stroke per Kelompok Usia (Line Chart) ---
        $definedAgeGroups = [];
        // Definisikan kelompok usia dari 10-19, 20-29, ..., 90-100
        for ($i = 10; $i <= 90; $i += 10) {
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
                        break;
                    }
                }
            }
        }

        $strokeIncidencePerAgeGroup = [];
        $ageGroupLabelsForChart = array_keys($definedAgeGroups);
        foreach ($definedAgeGroups as $label => $counts) {
            $incidence = ($counts['total'] > 0) ? ($counts['stroke'] / $counts['total']) * 100 : 0;
            $strokeIncidencePerAgeGroup[] = round($incidence, 2);
        }


        // --- 4. Data untuk Rata-rata Kadar Glukosa Pasien Stroke vs. Non-Stroke (Bar Chart) ---
        $glucoseStrokeSum = 0;
        $glucoseStrokeCount = 0;
        $glucoseNoStrokeSum = 0;
        $glucoseNoStrokeCount = 0;

        foreach ($allData as $item) {
            if (isset($item->avg_glucose_level) && isset($item->stroke)) {
                $glucose = (float)$item->avg_glucose_level;
                if ((int)$item->stroke === 1) {
                    $glucoseStrokeSum += $glucose;
                    $glucoseStrokeCount++;
                } else {
                    $glucoseNoStrokeSum += $glucose;
                    $glucoseNoStrokeCount++;
                }
            }
        }
        $avgGlucoseStroke = ($glucoseStrokeCount > 0) ? round($glucoseStrokeSum / $glucoseStrokeCount, 2) : 0;
        $avgGlucoseNoStroke = ($glucoseNoStrokeCount > 0) ? round($glucoseNoStrokeSum / $glucoseNoStrokeCount, 2) : 0;


        // --- 5. Data untuk Prevalensi Hipertensi dan Penyakit Jantung berdasarkan Status Stroke (Grouped Bar Chart) ---
        $hypertensionStroke = 0;
        $hypertensionNoStroke = 0;
        $heartDiseaseStroke = 0;
        $heartDiseaseNoStroke = 0;

        foreach ($allData as $item) {
            if (isset($item->hypertension) && isset($item->heart_disease) && isset($item->stroke)) {
                $hasHypertension = (int)$item->hypertension;
                $hasHeartDisease = (int)$item->heart_disease;
                $hasStroke = (int)$item->stroke;

                if ($hasStroke === 1) {
                    if ($hasHypertension === 1) $hypertensionStroke++;
                    if ($hasHeartDisease === 1) $heartDiseaseStroke++;
                } else { // No Stroke
                    if ($hasHypertension === 1) $hypertensionNoStroke++;
                    if ($hasHeartDisease === 1) $heartDiseaseNoStroke++;
                }
            }
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
            'genderStrokeCounts' => $genderStrokeCounts,
            'ageGroupLabelsForChart' => $ageGroupLabelsForChart,
            'strokeIncidencePerAgeGroup' => $strokeIncidencePerAgeGroup,
            'avgGlucoseStroke' => $avgGlucoseStroke, // Data baru untuk chart 4
            'avgGlucoseNoStroke' => $avgGlucoseNoStroke, // Data baru untuk chart 4
            'hypertensionStroke' => $hypertensionStroke, // Data baru untuk chart 5
            'hypertensionNoStroke' => $hypertensionNoStroke, // Data baru untuk chart 5
            'heartDiseaseStroke' => $heartDiseaseStroke, // Data baru untuk chart 5
            'heartDiseaseNoStroke' => $heartDiseaseNoStroke, // Data baru untuk chart 5
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
