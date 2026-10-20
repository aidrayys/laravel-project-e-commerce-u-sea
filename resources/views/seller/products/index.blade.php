@extends('layouts.app')

@section('title', 'Seller Products')

@push('styles')
<style>
    .product-table-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.5rem;
        background-color: #e0f2fe;
    }

    .product-description-cell {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 1.5;
        color: var(--gray);
        font-size: 0.9rem;
    }

    @media (max-width: 767px) {
        .product-description-cell {
            max-width: none;
        }
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <h1 class="page-title" style="margin-bottom: 0;">Seller Products</h1>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    <div class="cart-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td data-label="ID">{{ $product->id }}</td>
                        <td data-label="Name"><strong>{{ $product->name }}</strong></td>
                        <td data-label="Description">
                            <div class="product-description-cell">{{ $product->description }}</div>
                        </td>
                        <td data-label="Stock">{{ $product->stock }}</td>
                        <td data-label="Price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td data-label="Image">
                            <img src="{{ asset($product->image ?? 'images/placeholder.svg') }}"
                                 alt="{{ $product->name }}"
                                 class="product-table-thumb"
                                 onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'">
                        </td>
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
