<?php

namespace App\Services;

class DijkstraShippingService
{
    /**
     * Mengonversi string ETD menjadi nilai numerik hari terendah.
     * Contoh: "14 day" -> 14, "2-3 day" -> 2, "1 day" -> 1
     *
     * @param string $etdString
     * @return int
     */
    protected function parseEtdToDays(string $etdString): int
    {
        $etdString = str_replace([' day', ' days'], '', $etdString);
        if (strpos($etdString, '-') !== false) {
            $parts = explode('-', $etdString);
            return (int)$parts[0];
        }
        return (int)$etdString;
    }

    /**
     * Normalisasi nilai agar nilai yang lebih kecil menghasilkan skor lebih tinggi (inverse normalization).
     * Skor akan berada di antara 0 dan 1.
     *
     * @param float $value Nilai yang akan dinormalisasi (misal: cost atau days)
     * @param float $minValue Nilai minimum dari semua opsi untuk kriteria ini
     * @param float $maxValue Nilai maksimum dari semua opsi untuk kriteria ini
     * @return float
     */
    protected function normalizeInverse(float $value, float $minValue, float $maxValue): float
    {
        if ($maxValue === $minValue) {
            return 1.0; // Semua nilai sama, beri skor penuh (atau 0.0 jika 0 adalah terbaik)
        }
        return ($maxValue - $value) / ($maxValue - $minValue);
    }

    /**
     * Menemukan jalur terpendek (nilai terendah) menggunakan prinsip Dijkstra,
     * dengan bobot gabungan dari cost dan ETD.
     *
     * @param array $shippingOptions Daftar opsi pengiriman
     * @param float $weightTime Bobot preferensi untuk waktu (0.0 - 1.0)
     * @param float $weightCost Bobot preferensi untuk biaya (0.0 - 1.0)
     * @return array|null Opsi pengiriman terbaik atau null jika tidak ada opsi
     */
    public function findBestShippingOptionCombined(array $shippingOptions, float $weightTime, float $weightCost): ?object
    {
        if (empty($shippingOptions)) {
            return null;
        }

        // Pastikan bobot total adalah 1
        if (($weightTime + $weightCost) !== 1.0 && abs(($weightTime + $weightCost) - 1.0) > 0.001) {
            throw new \InvalidArgumentException("Total weight for time and cost must be 1.0");
        }

        // 1. Parsing ETD dan Kumpulkan Nilai Min/Max untuk Normalisasi
        $processedOptions = [];
        $allCosts = [];
        $allDays = [];

        foreach ($shippingOptions as $option) {
            $days = $this->parseEtdToDays($option->etd);
            $cost = $option->cost;

            $processedOptions[] = [
                'original_option' => $option,
                'days' => $days,
                'cost' => $cost,
            ];
            $allCosts[] = $cost;
            $allDays[] = $days;
        }

        // Hitung min/max dari semua data untuk normalisasi
        $minCost = min($allCosts);
        $maxCost = max($allCosts);
        $minDays = min($allDays);
        $maxDays = max($allDays);

        // 2. Hitung Bobot Gabungan (Combined Weight) untuk Setiap Opsi
        $graph = [];
        $distances = ['start' => 0, 'end' => PHP_FLOAT_MAX];
        $previous = ['start' => null, 'end' => null];
        $visited = [];
        $paths = [];

        foreach ($processedOptions as $index => $option) {
            // Normalisasi terbalik untuk biaya
            $normalizedCost = $this->normalizeInverse($option['cost'], $minCost, $maxCost);

            // Normalisasi terbalik untuk waktu
            $normalizedDays = $this->normalizeInverse($option['days'], $minDays, $maxDays);

            // Hitung skor gabungan (ini akan menjadi "bobot" untuk Dijkstra)
            // Penting: Dijkstra mencari MINIMUM bobot.
            // Skor yang kita hitung (normalizedCost * weightCost + normalizedDays * weightTime)
            // akan lebih tinggi jika opsi lebih baik (lebih murah/cepat).
            // Jadi, kita perlu "membalik" ini agar Dijkstra mencari nilai yang lebih kecil.
            // Cara paling sederhana adalah dengan 1 - skor_gabungan_normalized_terbalik
            // Atau, kita bisa menggunakan skor gabungan itu sendiri dan mengurutkan secara DESCENDING,
            // tapi Dijkstra selalu mencari MINIMUM.
            // Mari kita ubah agar bobot yang LEBIH KECIL berarti LEBIH BAIK.
            // Solusi: Gunakan 1.0 - (normalized_score)
            // Karena normalized_score 0-1, maka (1-score) juga 0-1.
            // Semakin tinggi normalized_score (semakin baik opsi), semakin kecil (1-score)nya.
            $combinedWeightedScore = ($normalizedCost * $weightCost) + ($normalizedDays * $weightTime);
            $dijkstraWeight = 1.0 - $combinedWeightedScore; // Inilah bobot yang akan dicari Dijkstra

            // Pastikan bobot tidak negatif (walaupun seharusnya tidak, karena normalized_score antara 0-1)
            $dijkstraWeight = max(0.0, $dijkstraWeight);


            // Setiap opsi adalah jalur langsung dari 'start' ke 'end_X'
            $graph['start']['end_' . $index] = $dijkstraWeight;
            $paths['end_' . $index] = $option['original_option']; // Simpan opsi asli

            // Inisialisasi jarak untuk node perantara
            $distances['end_' . $index] = PHP_FLOAT_MAX;
            $previous['end_' . $index] = null;
        }
        // Tambahkan node 'end' yang sebenarnya sebagai target akhir
        $graph['end'] = [];

        // Setiap node perantara mengarah ke node 'end' dengan bobot 0
        foreach ($processedOptions as $index => $option) {
            $graph['end_' . $index]['end'] = 0;
        }

        $nodes = array_keys($distances);

        // Dijkstra's core logic (sama seperti sebelumnya)
        while (!empty($nodes)) {
            $minDistance = PHP_FLOAT_MAX;
            $closestNode = null;

            foreach ($nodes as $node) {
                if (!in_array($node, $visited) && isset($distances[$node]) && $distances[$node] < $minDistance) {
                    $minDistance = $distances[$node];
                    $closestNode = $node;
                }
            }

            if ($closestNode === null) {
                break;
            }

            $visited[] = $closestNode;
            $nodes = array_diff($nodes, [$closestNode]);

            if (isset($graph[$closestNode])) {
                foreach ($graph[$closestNode] as $neighbor => $weight) {
                    $newDistance = $distances[$closestNode] + $weight;
                    if (!isset($distances[$neighbor]) || $newDistance < $distances[$neighbor]) {
                        $distances[$neighbor] = $newDistance;
                        $previous[$neighbor] = $closestNode;
                    }
                }
            }
        }

        // Rekonstruksi jalur dan temukan opsi terbaik
        $bestOption = null;
        $minCombinedWeight = PHP_FLOAT_MAX;

        // Cari di antara semua opsi yang mencapai 'end'
        foreach ($processedOptions as $index => $option) {
            $targetNode = 'end_' . $index;
            if (isset($distances[$targetNode])) { // Pastikan node ini dijangkau
                $currentPathWeight = $distances[$targetNode]; // Ini adalah bobot dari start ke opsi ini

                // Karena kita menggunakan (1 - normalized_score) sebagai bobot Dijkstra,
                // nilai terkecil dari `currentPathWeight` akan merepresentasikan opsi terbaik.
                if ($currentPathWeight < $minCombinedWeight) {
                    $minCombinedWeight = $currentPathWeight;
                    $bestOption = $option['original_option'];
                }
            }
        }
        // Pastikan opsi terbaik ditemukan dan itu memang jalur ke 'end'
        if ($bestOption && isset($distances['end']) && $distances['end'] < PHP_FLOAT_MAX) {
            // Sebenarnya, yang kita cari adalah opsi yang memiliki bobot terendah dari 'start' ke 'end_X'
            // karena jalur dari 'end_X' ke 'end' bobotnya 0.
            return $bestOption;
        }


        return null;
    }
}
