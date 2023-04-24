@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-1 py-2 border-b-2 border-indigo-100 text-base font-medium leading-5 text-white focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out hover:text-gray-100'
    : 'inline-flex items-center px-1 py-2 border-b-2 border-transparent text-base font-medium leading-5 text-gray-300 hover:text-white hover:border-gray-300 focus:outline-none focus:text-gray-300 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>