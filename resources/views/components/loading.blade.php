<span {{ $attributes->class([
    'h-6' => !$attributes->has('class') || !str()->contains($attributes->get('class'), ['h-', '!h-']),
    'w-6' => !$attributes->has('class') || !str()->contains($attributes->get('class'), ['w-', '!w-']),
]) }}>
    <x-icon.arrow-path class="w-full h-full animate-spin font-bold" />
</span>