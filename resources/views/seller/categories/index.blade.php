@extends('layouts.app')

@section('title', 'Seller Categories')

@push('styles')
<style>
    .category-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        padding: 0.25rem 0.625rem;
        background-color: var(--light-blue);
        color: var(--ocean);
        border-radius: 9999px;
        font-weight: 700;
        font-size: 0.875rem;
    }

    .category-count.zero {
        background-color: var(--gray-light);
        color: var(--gray);
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <h1 class="page-title" style="margin-bottom: 0;">Seller Categories</h1>
        <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">+ Add Category</a>
    </div>

    <div class="cart-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Product Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td data-label="ID">{{ $category->id }}</td>
                        <td data-label="Category Name">{{ $category->name }}</td>
                        <td data-label="Product Count">
                            <span class="category-count {{ $category->products_count === 0 ? 'zero' : '' }}">
                                {{ $category->products_count }}
                            </span>
                        </td>
                        <td data-label="Actions">
                            <div class="cart-actions-cell">
                                <a href="{{ route('seller.categories.edit', $category) }}" class="btn btn-outline btn-small">Edit</a>
                                <form action="{{ route('seller.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-small">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state" style="text-align: center; padding: 2rem;">
                            <p>No categories found.</p>
                            <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">Add Category</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
