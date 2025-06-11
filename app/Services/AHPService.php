<?php

namespace App\Services;

//use App\Models\Produk; // Pastikan model Produk sudah ada
//use Illuminate\Support\Facades\DB; // Untuk ambil data merk jika dibutuhkan

class AHPService
{
    // Skala perbandingan Saaty
    protected array $saatyScale = [
        1 => 1,    // Sama pentingnya
        2 => 1 / 2,  // Agak kurang penting
        3 => 1 / 3,  // Kurang penting
        4 => 1 / 4,
        5 => 1 / 5,  // Jauh kurang penting
        6 => 1 / 6,
        7 => 1 / 7,  // Sangat jauh kurang penting
        8 => 1 / 8,
        9 => 1 / 9,  // Mutlak kurang penting
    ];

    // Matriks perbandingan berpasangan kriteria (hardcoded sebagai contoh)
    // Disesuaikan untuk hanya 3 kriteria: Harga, CPU_Score, GPU_Score
    protected array $criteriaComparisonMatrix = [
        // Kriteria: Harga, CPU_Score, GPU_Score
        'harga' => [
            'harga' => 1,
            'cpu_score' => 2,     // Harga 2x lebih penting dari CPU_Score
            'gpu_score' => 3,      // Harga 3x lebih penting dari GPU_Score
            'bobot' => 4
        ],
        'cpu_score' => [
            'harga' => 1 / 2,
            'cpu_score' => 1,
            'gpu_score' => 2,      // CPU_Score 2x lebih penting dari GPU_Score
            'bobot' => 3
        ],
        'gpu_score' => [
            'harga' => 1 / 3,
            'cpu_score' => 1 / 2,
            'gpu_score' => 1,
            'bobot' => 2
        ],
        'bobot' => [
            'harga' => 1 / 4,
            'cpu_score' => 1 / 3,
            'gpu_score' => 1 / 2,
            'bobot' => 1
        ],
    ];

    // Daftar kriteria yang digunakan (hanya 4)
    protected array $criteria = [
        'harga',
        'cpu_score',
        'gpu_score',
        'bobot',
    ];

    /**
     * Hitung bobot kriteria berdasarkan matriks perbandingan berpasangan.
     *
     * @param array $matrix
     * @return array
     */
    public function calculateCriteriaWeights(array $matrix): array
    {
        $numCriteria = count($matrix);
        if ($numCriteria === 0) {
            return [];
        }

        // 1. Normalisasi matriks (jumlah kolom)
        $columnSums = array_fill_keys($this->criteria, 0.0);
        foreach ($matrix as $rowCriterion => $values) {
            foreach ($values as $colCriterion => $value) {
                if (isset($columnSums[$colCriterion]))
                    $columnSums[$colCriterion] += $value;
            }
        }

        $normalizedMatrix = [];
        foreach ($matrix as $rowCriterion => $values) {
            foreach ($values as $colCriterion => $value) {
                // Pastikan pembagian tidak oleh nol
                if (isset($columnSums[$colCriterion]))
                    $normalizedMatrix[$rowCriterion][$colCriterion] = ($columnSums[$colCriterion] != 0) ? $value / $columnSums[$colCriterion] : 0;
            }
        }

        // 2. Rata-rata baris untuk mendapatkan bobot
        $weights = [];
        foreach ($normalizedMatrix as $rowCriterion => $values) {
            $weights[$rowCriterion] = array_sum($values) / $numCriteria;
        }

        return $weights;
    }

    /**
     * Normalisasi skor alternatif untuk setiap kriteria.
     * Untuk kriteria 'harga', skor yang lebih kecil lebih baik (normalisasi terbalik).
     *
     * @param array $alternatives
     * @param string $criteriaKey
     * @return array
     */
    protected function normalizeAlternativeScores(array $alternatives, string $criteriaKey): array
    {
        $scores = [];
        foreach ($alternatives as $alt) {
            // Ambil nilai dari properti langsung
            if (in_array($criteriaKey, ['harga', 'cpu_score', 'gpu_score', 'bobot'])) {
                $scores[] = $alt[$criteriaKey];
            } else {
                $scores[] = 0; // Kriteria tidak dikenal
            }
        }

        if (empty($scores)) {
            return array_fill(0, count($alternatives), 0.0);
        }

        $normalizedScores = [];
        $maxValue = max($scores);
        $minValue = min($scores);

        foreach ($scores as $score) {
            if ($criteriaKey === 'harga') {
                // Untuk harga: Makin kecil makin baik
                if ($maxValue === $minValue) { // Tangani kasus semua nilai sama
                    $normalizedScores[] = 1.0;
                } else {
                    $normalizedScores[] = ($maxValue - $score) / ($maxValue - $minValue);
                }
            } else {
                // Untuk CPU_Score dan GPU_Score: Makin besar makin baik
                $normalizedScores[] = ($maxValue != 0) ? $score / $maxValue : 0;
            }
        }

        return $normalizedScores;
    }


    /**
     * Mendapatkan rekomendasi produk berdasarkan AHP.
     *
     * @param int $limit Jumlah rekomendasi yang diinginkan
     * @return array Array produk yang direkomendasikan, diurutkan berdasarkan skor tertinggi
     */
    public function getRecommendations($products, int $limit = 10): array
    {
        // 1. Hitung bobot kriteria
        $criteriaWeights = $this->calculateCriteriaWeights($this->criteriaComparisonMatrix);

        if (empty($criteriaWeights)) {
            return []; // Tidak ada bobot kriteria yang dihitung
        }

        // 2. Ambil semua produk dari database
        // Pastikan Anda memuat relasi 'merk' jika Anda ingin menampilkannya
        // $products = Produk::with('merk')->get();

        if ($products->isEmpty()) {
            return []; // Tidak ada produk ditemukan
        }

        $alternativeScores = [];

        // Inisialisasi skor untuk setiap produk
        foreach ($products as $product) {
            $alternativeScores[$product->id] = [
                'product' => $product,
                'total_score' => 0.0,
                'normalized_criteria_scores' => [] // Untuk menyimpan skor normalisasi per kriteria
            ];
        }


        // 3. Normalisasi skor alternatif untuk setiap kriteria
        foreach ($this->criteria as $criterion) {
            // Kita perlu mengubah Collection menjadi array agar konsisten dengan cara `normalizeAlternativeScores` bekerja
            $normalizedCriterionScores = $this->normalizeAlternativeScores($products->toArray(), $criterion);

            // Distribusi skor normalisasi kembali ke setiap produk
            $i = 0;
            foreach ($products as $product) {
                $alternativeScores[$product->id]['normalized_criteria_scores'][$criterion] = $normalizedCriterionScores[$i] ?? 0;
                $i++;
            }
        }

        // 4. Hitung skor akhir setiap alternatif
        foreach ($alternativeScores as $productId => $data) {
            $totalScore = 0.0;
            foreach ($this->criteria as $criterion) {
                // Kalikan skor normalisasi alternatif dengan bobot kriteria
                $weightedScore = ($data['normalized_criteria_scores'][$criterion] ?? 0) * ($criteriaWeights[$criterion] ?? 0);
                $totalScore += $weightedScore;
            }
            $alternativeScores[$productId]['total_score'] = $totalScore;
        }

        // 5. Urutkan produk berdasarkan skor tertinggi
        usort($alternativeScores, function ($a, $b) {
            return $b['total_score'] <=> $a['total_score'];
        });

        // Ambil sejumlah rekomendasi yang diminta
        return array_slice($alternativeScores, 0, $limit);
    }
}
