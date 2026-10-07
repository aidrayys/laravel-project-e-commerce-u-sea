@php
    $isEdit = isset($product);
    $title = $isEdit ? 'Edit Product' : 'Add Product';
    $action = $isEdit ? route('seller.products.update', $product) : route('seller.products.store');
    $method = $isEdit ? 'PATCH' : 'POST';
    $product = $product ?? null;

    $categories = [
        'Fresh Seafood',
        'Fish',
        'Shrimp',
        'Squid',
        'Processed Seafood',
        'Sambal',
        'Seafood Snacks',
        'Others',
    ];

    $currentCategory = old('category', $product?->category);
    $isOtherCategory = $currentCategory && !in_array($currentCategory, $categories, true);
    $selectedCategory = $isOtherCategory ? 'Others' : $currentCategory;
    $otherCategoryValue = $isOtherCategory ? $currentCategory : old('category_other', '');

    $isPromo = old('is_promo', $product?->is_promo ?? false);
    $basePrice = old('price', $product?->original_price ?? $product?->price ?? '');
    $discountPercentage = old('discount_percentage', $product?->discount_percentage ?? '');
    $priceAfterDiscount = old('price_after_discount', $product?->is_promo ? $product->price : '');
@endphp

<h1 class="page-title">{{ $title }}</h1>

<div class="product-form-card">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        @if ($isEdit)
            @method($method)
        @endif

        <div class="product-form-grid">
            <div class="form-group form-group-full">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $product?->name) }}" required>
            </div>

            <div class="form-group form-group-full">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-textarea" rows="4" required>{{ old('description', $product?->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Price (Rp)</label>
                <input type="number" id="price" name="price" class="form-input" value="{{ $basePrice }}" min="0" required>
            </div>

            <div class="form-group">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" id="stock" name="stock" class="form-input" value="{{ old('stock', $product?->stock) }}" min="0" required>
            </div>

            <div class="form-group">
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-input form-select" required>
                    <option value="" disabled {{ empty($selectedCategory) ? 'selected' : '' }}>Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ $selectedCategory === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" id="image" name="image" class="form-input form-file" accept="image/*">
                <div class="image-preview" id="imagePreview">
                    @if ($isEdit && $product?->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" id="previewImg">
                    @endif
                </div>
                <small class="form-hint">Accepted: JPG, PNG, GIF, WebP. Max 2MB.</small>
            </div>
        </div>

        <div class="form-group category-other-group {{ $isOtherCategory ? '' : 'hidden' }}" style="margin-top: 1rem;">
            <label for="category_other" class="form-label">Specify Category</label>
            <input type="text" id="category_other" name="category_other" class="form-input" value="{{ $otherCategoryValue }}" {{ $isOtherCategory ? 'required' : '' }}>
        </div>

        <div class="promo-section">
            <label class="promo-toggle">
                <input type="checkbox" id="is_promo" name="is_promo" value="1" {{ $isPromo ? 'checked' : '' }}>
                <span class="promo-toggle-slider"></span>
                <span class="promo-toggle-label">Apakah ingin memberikan promo?</span>
            </label>

            <div class="promo-fields {{ $isPromo ? '' : 'hidden' }}">
                <div class="promo-fields-grid">
                    <div class="form-group">
                        <label for="discount_percentage" class="form-label">Discount (%)</label>
                        <input type="number" id="discount_percentage" name="discount_percentage" class="form-input" value="{{ $discountPercentage }}" min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label for="price_after_discount" class="form-label">Price After Discount (Rp)</label>
                        <input type="text" id="price_after_discount" class="form-input" value="{{ $priceAfterDiscount ? number_format($priceAfterDiscount, 0, ',', '.') : '' }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Product' : 'Save Product' }}</button>
            <a href="{{ route('seller.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@push('styles')
<style>
    .product-form-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        max-width: 100%;
    }

    @media (min-width: 768px) {
        .product-form-card {
            padding: 2rem;
        }
    }

    .product-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .product-form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .product-form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        padding-right: 2.5rem;
    }

    .form-file {
        padding: 0.5rem;
        font-size: 0.9rem;
    }

    .form-file::file-selector-button {
        background-color: var(--light-blue);
        color: var(--ocean-dark);
        border: none;
        border-radius: var(--radius);
        padding: 0.5rem 0.875rem;
        margin-right: 0.75rem;
        font-weight: 600;
        cursor: pointer;
    }

    .image-preview {
        margin-top: 0.75rem;
        min-height: 120px;
        border: 2px dashed #e2e8f0;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f8fafc;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
    }

    .image-preview:empty::before {
        content: 'Image preview will appear here';
        color: var(--gray);
        font-size: 0.85rem;
    }

    .form-hint {
        display: block;
        margin-top: 0.375rem;
        font-size: 0.8rem;
        color: var(--gray);
    }

    .category-other-group.hidden,
    .promo-fields.hidden {
        display: none;
    }

    .promo-section {
        padding-top: 0.5rem;
    }

    .promo-toggle {
        display: inline-flex;
        align-items: center;
        gap: 0.875rem;
        cursor: pointer;
        user-select: none;
    }

    .promo-toggle input {
        display: none;
    }

    .promo-toggle-slider {
        width: 48px;
        height: 26px;
        background-color: #cbd5e1;
        border-radius: 999px;
        position: relative;
        transition: background-color 0.25s;
        flex-shrink: 0;
    }

    .promo-toggle-slider::before {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 20px;
        height: 20px;
        background-color: var(--white);
        border-radius: 50%;
        transition: transform 0.25s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .promo-toggle input:checked + .promo-toggle-slider {
        background-color: var(--ocean);
    }

    .promo-toggle input:checked + .promo-toggle-slider::before {
        transform: translateX(22px);
    }

    .promo-toggle-label {
        font-weight: 600;
        color: var(--navy);
        font-size: 0.95rem;
    }

    .promo-fields {
        margin-top: 1rem;
        padding: 1rem;
        background-color: #f8fafc;
        border-radius: var(--radius);
        border: 1px solid #e2e8f0;
    }

    .promo-fields-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .promo-fields-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        padding-top: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    const categorySelect = document.getElementById('category');
    const categoryOtherGroup = document.querySelector('.category-other-group');
    const categoryOtherInput = document.getElementById('category_other');

    categorySelect.addEventListener('change', function () {
        if (this.value === 'Others') {
            categoryOtherGroup.classList.remove('hidden');
            categoryOtherInput.required = true;
        } else {
            categoryOtherGroup.classList.add('hidden');
            categoryOtherInput.required = false;
            categoryOtherInput.value = '';
        }
    });

    const promoToggle = document.getElementById('is_promo');
    const promoFields = document.querySelector('.promo-fields');
    const priceInput = document.getElementById('price');
    const discountInput = document.getElementById('discount_percentage');
    const priceAfterDiscountInput = document.getElementById('price_after_discount');

    function formatRupiah(value) {
        return 'Rp' + value.toLocaleString('id-ID');
    }

    function calculateDiscountedPrice() {
        const price = parseFloat(priceInput.value) || 0;
        const discount = parseFloat(discountInput.value) || 0;

        if (price > 0 && discount > 0 && discount <= 100) {
            const discounted = Math.round(price - (price * discount / 100));
            priceAfterDiscountInput.value = formatRupiah(discounted);
        } else if (price > 0) {
            priceAfterDiscountInput.value = formatRupiah(price);
        } else {
            priceAfterDiscountInput.value = '';
        }
    }

    function togglePromoFields() {
        if (promoToggle.checked) {
            promoFields.classList.remove('hidden');
            discountInput.required = true;
        } else {
            promoFields.classList.add('hidden');
            discountInput.required = false;
            discountInput.value = '';
            priceAfterDiscountInput.value = '';
        }
        calculateDiscountedPrice();
    }

    promoToggle.addEventListener('change', togglePromoFields);
    priceInput.addEventListener('input', calculateDiscountedPrice);
    discountInput.addEventListener('input', calculateDiscountedPrice);

    togglePromoFields();

    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" id="previewImg">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
