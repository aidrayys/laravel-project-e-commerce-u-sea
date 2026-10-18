@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-lg border-gray-300 bg-white text-[#0B1F3A] placeholder-gray-400 shadow-sm focus:border-[#087EA4] focus:ring-[#087EA4] focus:ring-2 transition-colors duration-200']) }}>
