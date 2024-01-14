<div
    class="flex flex-col items-center justify-center p-0 m-0 space-y-3 lg:space-y-0 lg:items-stretch lg:flex-row"
>

    <div class="w-9/12 bg-white relative shadow rounded-xl border border-fuchsia-300/50 relative">
        <button
            class="absolute right-6 -top-9 text-fuchsia-500 bg-transparent hover:text-fuchsia-600 focus:text-fuchsia-600"
            x-on:click="window.location.href = '{{ route('index') }}'"
        >
            Voltar
        </button>

        <div class="flex items-center mb-3.5 mt-5 flex-col px-5">
            {{-- STATUS --}}
            <div class="self-end">
                <span class="text-gray-600">Status:</span>
                <span @class([
                    "font-semibold",
                    "text-green-600" => $connected,
                    "text-red-600"   => !$connected
                ])>
                    {{ $connected ? 'Conectado' : 'Desconectado' }}
                </span>
            </div>

            @if (!$connected)
                @if (empty($qrcodeInBase64))
                    <x-button text="Conectar o whatsapp" wire:loading wire:target="startSession" />
                @else
                    <div class="inline-flex space-x-4">
                        <span class="text-center text-gray-500">Escaneie o QR Code</span>
                        <button class="text-gray-600 hover:text-gray-800 focus:text-gray-800 cursor-pointer" wire:click="startSession">
                            <x-icon.arrow-path class="w-5 h-5" wire:loading.class="animate-spin" wire:target="startSession" />
                        </button>
                    </div>
                    <img src="{{ $qrcodeInBase64 }}" class="select-none">
                @endif
            @endif
        </div>

    </div>
</div>

@push('scripts')
    {{-- @vite('resources/js/laravel-echo.js') --}}
@endpush