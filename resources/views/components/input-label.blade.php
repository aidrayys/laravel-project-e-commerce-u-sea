@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-[#0B1F3A]']) }}>
    {{ $value ?? $slot }}
</label>
