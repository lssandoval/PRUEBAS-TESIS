@props(['active'])

@php
$isActive = ($active ?? false);

$classes = $isActive
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 dark:text-gray-100 focus:outline-none focus:border-yellow-300 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-yellow-500 dark:hover:text-yellow-300 hover:border-yellow-300 dark:hover:border-yellow-300 focus:outline-none focus:text-yellow-500 dark:focus:text-yellow-300 focus:border-yellow-300 dark:focus:border-yellow-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
