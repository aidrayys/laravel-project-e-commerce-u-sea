@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
    <h1 class="page-title">Add Category</h1>

    <div class="product-form-card">
        <form action="{{ route('seller.categories.store') }}" method="POST" class="product-form">
            @csrf

            <div class="form-group form-group-full">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name')
                    <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Category</button>
                <a href="{{ route('seller.categories.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
