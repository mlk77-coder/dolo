
@props([
    'variant' => 'light',
    'size' => 'md',
    'color' => 'primary',
    'startIcon' => null,
    'endIcon' => null,
])

@php
    $baseStyles = 'inline-flex items-center px-2.5 py-0.5 justify-center gap-1 rounded-full font-medium capitalize';

    $sizeStyles = [
        'sm' => 'text-xs',
        'md' => 'text-sm',
    ];

    $variants = [
        'light' => [
            'primary' => 'bg-blue-50 text-blue-500',
            'success' => 'bg-green-50 text-green-600',
            'error' => 'bg-red-50 text-red-600',
            'warning' => 'bg-yellow-50 text-yellow-600',
            'info' => 'bg-sky-50 text-sky-500',
            'light' => 'bg-gray-100 text-gray-700',
            'dark' => 'bg-gray-500 text-white',
        ],
        'solid' => [
            'primary' => 'bg-blue-500 text-white',
            'success' => 'bg-green-500 text-white',
            'error' => 'bg-red-500 text-white',
            'warning' => 'bg-yellow-500 text-white',
            'info' => 'bg-sky-500 text-white',
            'light' => 'bg-gray-400 text-white',
            'dark' => 'bg-gray-700 text-white',
        ],
    ];

    $sizeClass = $sizeStyles[$size] ?? $sizeStyles['md'];
    $colorStyles = $variants[$variant][$color] ?? $variants['light']['primary'];
@endphp

<span class="{{ $baseStyles }} {{ $sizeClass }} {{ $colorStyles }}" {{ $attributes }}>
    @if($startIcon)
        {!! $startIcon !!}
    @endif

    {{ $slot }}

    @if($endIcon)
        {!! $endIcon !!}
    @endif
</span>
