<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductSearch extends Component
{
    public string $q = '';
    public $results = [];

    public function updatedQ()
    {
        $term = trim($this->q);

        $this->results = $term !== ''
            ? Product::where(function ($query) use ($term) {
                    $query->where('name', 'like', "%{$term}%")
                          ->orWhere('description', 'like', "%{$term}%");
                })
                ->where('is_active', 1) // ✅ apply to all
                ->orderBy('name')
                ->limit(10)
                ->get()
            : [];
    }

    public function render()
    {
        return view('livewire.product-search', [
            'results' => $this->results,
        ]);
    }
}
