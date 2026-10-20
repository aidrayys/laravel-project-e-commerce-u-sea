@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <h1 class="page-title">Edit Category</h1>

    <div class="product-form-card">
        <form action="{{ route('seller.categories.update', $category) }}" method="POST" class="product-form">
            @csrf
            @method('PATCH')

            <div class="form-group form-group-full">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="{{ route('seller.categories.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
