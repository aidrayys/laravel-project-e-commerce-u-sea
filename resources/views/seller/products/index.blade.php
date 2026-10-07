@extends('layouts.app')

@section('title', 'Seller Products')

@section('content')
    <div class="section-header">
        <h1 class="page-title" style="margin-bottom: 0;">Seller Products</h1>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    <div class="cart-table">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td data-label="Product">
                            <div class="cart-item">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    <div style="font-size: 0.875rem; color: var(--gray);">{{ $product->seller_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Category">{{ $product->category }}</td>
                        <td data-label="Price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td data-label="Stock">{{ $product->stock }}</td>
                        <td data-label="Actions">
                            <div class="cart-actions-cell">
                                <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-outline btn-small">Edit</a>
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-small">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
