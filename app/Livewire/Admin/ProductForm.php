<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $product;
    public $name;
    public $brand;
    public $sku;
    public $description;
    public $price;
    public $stock_quantity;
    public $image_path;
    public $category_id;
    public $image;

    public function mount($product = null)
    {
        if ($product) {
            $this->product = Product::find($product);
            $this->name = $this->product->name;
            $this->brand = $this->product->brand;
            $this->sku = $this->product->sku;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
            $this->stock_quantity = $this->product->stock_quantity;
            $this->image_path = $this->product->image_path;
            $this->category_id = $this->product->category_id;
        } else {
            $this->product = null;
            $this->stock_quantity = 0;
        }
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'sku' => 'required|string|max:255|unique:products,sku',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048|mimes:jpeg,png,webp',
    ];

    public function save()
    {
        if ($this->product) {
            $this->rules['sku'] = 'required|string|max:255|unique:products,sku,' . $this->product->id;
        }

        $this->validate();

        // Handle image upload
        if ($this->image) {
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('products', $imageName, 'public');
            $imagePath = 'storage/products/' . $imageName;
        } else {
            $imagePath = $this->image_path;
        }

        $productData = [
            'name' => $this->name,
            'brand' => $this->brand,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'category_id' => $this->category_id,
            'image_path' => $imagePath,
        ];

        if ($this->product) {
            $this->product->update($productData);
            session()->flash('message', 'Produit modifié avec succès.');
        } else {
            Product::create($productData);
            session()->flash('message', 'Produit créé avec succès.');
        }

        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        $categories = Category::all();
        
        return view('livewire.admin.product-form', [
            'categories' => $categories,
            'isEdit' => $this->product !== null
        ])->layout('layouts.admin', ['title' => $this->product ? 'Modifier le Produit' : 'Nouveau Produit']);
    }
}
