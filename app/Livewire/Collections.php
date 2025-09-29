<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class Collections extends Component
{
    public function render()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', 1)->latest();
        }])->get();

        return view('livewire.collections', compact('categories'))
            ->layout('layouts.app'); 
    }
}
