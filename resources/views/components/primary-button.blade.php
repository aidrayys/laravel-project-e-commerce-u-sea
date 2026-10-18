<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-[#087EA4] border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-[#065f7a] focus:bg-[#065f7a] active:bg-[#0B1F3A] focus:outline-none focus:ring-2 focus:ring-[#18AEE5] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm']) }}>
    {{ $slot }}
</button>
