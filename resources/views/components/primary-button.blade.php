<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-[#19A148] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-[#19A148]/50 focus:ring-offset-2 transition ease-in-out duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
