<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public array $selected = [];
    public bool $showDeleteModal = false;

    protected $listeners = [
        'confirmBulkDelete' => 'confirmBulkDelete',
    ];

    // Open modal for bulk delete
    public function confirmBulkDelete(): void
    {
        if (count($this->selected) === 0) {
            $this->dispatch('customFlash', [
                'message' => '⚠️ Please select at least one customer to delete.',
                'type'    => 'warning',
            ]);
            return;
        }
        $this->showDeleteModal = true;
    }

    // Open modal for single delete from row
    public function confirmDelete(int $id): void
    {
        $this->selected = [$id];
        $this->showDeleteModal = true;
    }

    // Perform delete
    public function deleteSelected(): void
    {
        if (empty($this->selected)) {
            $this->showDeleteModal = false;
            return;
        }

        $customers = User::whereIn('id', $this->selected)
            ->where('role', 'customer')
            ->get();

        foreach ($customers as $customer) {
            if (method_exists($customer, 'orders')) {
                $customer->orders()->delete();
            }
            $customer->delete();
        }

        $count = $customers->count();

        $this->reset(['selected', 'showDeleteModal']);
        $this->resetPage();

        $msg = $count === 1
            ? 'Customer deleted successfully'
            : "{$count} customers deleted successfully";

        $this->dispatch('customFlash', [
            'message' => "🗑 {$msg}",
            'type'    => 'success',
        ]);
    }

    // Toggle status
    public function toggleStatus(int $id): void
    {
        $customer = User::find($id);
        if (!$customer) return;

        if ($customer->status === 'active') {
            $customer->status = 'inactive';
            $customer->save();

            $this->dispatch('customFlash', [
                'message' => '🚫 Customer deactivated successfully',
                'type'    => 'error',
            ]);
        } else {
            $customer->status = 'active';
            $customer->save();

            $this->dispatch('customFlash', [
                'message' => '✅ Customer activated successfully',
                'type'    => 'success',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.customers.index', [
            'customers' => User::where('role', 'customer')->latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
