@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1 class="page-title">Seafood Products</h1>

    <form action="{{ route('products.index') }}" method="GET" class="search-bar">
        <input type="text"
               name="search"
               class="form-input"
               placeholder="Search seafood or seller..."
               value="{{ request('search') }}">

        <select name="category" class="form-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if ($products->isEmpty())
        <div class="empty-state">
            <h2>No products found</h2>
            <p>Try a different keyword or category.</p>
            <a href="{{ route('products.index') }}" class="btn btn-outline">Clear Filters</a>
        </div>
    @else
        <div class="product-grid">
            @foreach ($products as $product)
                @include('products.card', ['product' => $product])
            @endforeach
        </div>
    @endif
@endsection
