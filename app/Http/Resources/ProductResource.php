<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (isset($this["normalized_criteria_scores"])) {
            return [
                "id" => $this["product"]->id,
                'merk_id' => $this["product"]->merk_id,
                'kategori' => $this["product"]->kategori,
                'model' => $this["product"]->model,
                'harga' => $this["product"]->harga,
                'bobot' => $this["product"]->bobot,
                'cpu_score' => $this["product"]->cpu_score,
                'gpu_score' => $this["product"]->gpu_score,
                'deskripsi' => $this["product"]->deskripsi,
                "merk" => $this["product"]->merk,
                "normalized_criteria_scores" => $this["normalized_criteria_scores"],
                "total_score" => $this["total_score"]
            ];
        }

        return parent::toArray($request);
    }
}
