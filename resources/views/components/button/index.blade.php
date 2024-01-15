@props(['text' => ''])

<button
    type="button"
    class="px-4 py-2 mt-5 font-semibold text-white border rounded-3xl bg-fuchsia-500 hover:bg-fuchsia-600 focus:bg-fuchsia-600 focus-visible:outline-fuchsia-800/70
    flex items-center justify-center disabled:bg-fuchsia-400/75 disabled:cursor-wait"
    wire:click="startSession"

    @if ($attributes->hasANy(['wire:loading', 'wire:target']))
    wire:loading.attr="disabled"
    {{ $attributes->whereStartsWith(['wire:target']) }}
    @endif
>
    <x-loading {{ $attributes->whereStartsWith(['wire:target']) }} wire:loading class="text- h-5 w-5 mr-2" />
    <span>{{ $text ?? $slot ?? '' }}</span>
</button>