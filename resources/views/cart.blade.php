@extends('layouts.admin')

@section('title', 'Mon Panier')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mon Panier</h1>
</div>

<livewire:shopping-cart />
@endsection
