@props(['active', 'route'])

@php
$classes = ($active ?? false)
            ? 'gap-3 items-center flex px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5  focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'gap-3 items-center flex px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 hover:border-gray-300 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    <p class="hidden group-hover:block">{{ $route }}</p>
</a>
