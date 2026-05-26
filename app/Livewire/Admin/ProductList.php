<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $categoryFilter = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $stockFilter = '';

    protected $paginationTheme = 'tailwind';

    public function deleteProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->delete();
            session()->flash('message', 'Produit supprimé avec succès.');
        }
    }

    // Reset pagination when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function updatingStockFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with('category');

        // Search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('brand', 'like', '%' . $this->search . '%')
                ->orWhere('sku', 'like', '%' . $this->search . '%');
        }

        // Category filter
        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        // Price range filter
        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        // Stock filter
        if ($this->stockFilter === 'in_stock') {
            $query->where('stock_quantity', '>', 0);
        } elseif ($this->stockFilter === 'out_of_stock') {
            $query->where('stock_quantity', 0);
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.product-list', [
            'products' => $products,
            'categories' => \App\Models\Category::all()
        ])->layout('layouts.admin', ['title' => 'Gestion des Produits']);
    }
}
