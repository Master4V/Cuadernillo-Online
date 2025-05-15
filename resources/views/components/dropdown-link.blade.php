@props(['active' => false])

@php
    $classes = $active
        ? 'block w-full px-4 py-2 text-start text-sm leading-5 text-yellow-700 font-semibold focus:outline-none transition duration-150 ease-in-out'
        : 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-yellow-100 hover:text-yellow-700 focus:outline-none focus:bg-yellow-100 focus:text-yellow-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
