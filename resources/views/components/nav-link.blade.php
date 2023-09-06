@props(['active'])

@php
    $classes = $active ?? false ? 'inline-flex items-center ml-8 px-1 pt-1 border-b-2 border-white text-sm font-medium leading-5 text-white focus:outline-none focus:border-blue-100 transition duration-150 ease-in-out' : 'inline-flex items-center ml-8 px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-blue-300 hover:text-blue-100 hover:border-blue-100 focus:outline-none focus:text-blue-100 focus:border-blue-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
