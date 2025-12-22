@props([
    'title' => '',
    'desc' => '',
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-200 bg-white']) }}>
    <!-- Card Header -->
    @if($title || $desc)
    <div class="px-6 py-5">
        @if($title)
        <h3 class="text-base font-medium text-gray-800">
            {{ $title }}
        </h3>
        @endif
        @if($desc)
            <p class="mt-1 text-sm text-gray-500">
                {{ $desc }}
            </p>
        @endif
    </div>
    @endif

    <!-- Card Body -->
    <div class="p-4 sm:p-6 {{ ($title || $desc) ? 'border-t border-gray-100' : '' }}">
        <div class="space-y-6">
            {{ $slot }}
        </div>
    </div>
</div>