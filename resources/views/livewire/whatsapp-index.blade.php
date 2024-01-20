<div
    class="flex flex-col items-center justify-center p-0 m-0 space-y-3 lg:space-y-0 lg:items-stretch lg:flex-row"
    x-data
>

    <div class="w-11/12 lg:w-9/12 bg-white mt-5 lg:mt-0 relative shadow rounded-xl border border-fuchsia-300/50">
        <button
            class="absolute right-4 -top-7 lg:right-6 lg:-top-8 text-fuchsia-500 bg-transparent hover:text-fuchsia-600 focus:text-fuchsia-600"
            x-on:click="window.location.href = '{{ route('index') }}'"
        >
            Voltar
        </button>

        <div class="flex items-center mb-3.5 mt-5 flex-col px-5">

            {{-- BOTÃO DE DESLOGAR DO WHATSAPP + STATUS --}}
            <div class="flex flex-row justify-between w-full">
                <div>
                    @if ($connected)
                        <button
                            class="p-0 bg-transparent text-fuchsia-500 hover:text-fuchsia-600 focus:text-fuchsia-600 disabled:cursor-wait disabled:text-fuchsia-400/75"
                            wire:click="logoutSession"
                            wire:loading.attr="disabled"
                        >
                            <x-loading wire:loading wire:target="logoutSession" />
                            <x-icon.exit wire:loading.remove wire:target="logoutSession" />
                        </button>
                    @endif
                </div>

                {{-- STATUS --}}
                <div>
                    <span class="text-gray-600">Status:</span>
                    <span @class([
                        "font-semibold",
                        "text-green-600" => $connected,
                        "text-red-600"   => !$connected
                    ])>
                        {{ $connected ? 'Conectado' : 'Desconectado' }}
                    </span>
                </div>
            </div>

            {{-- QR CODE --}}
            @if (!$connected)
                @if (empty($qrcodeInBase64))
                    <x-button text="Conectar o whatsapp" wire:loading wire:target="startSession" />
                @else
                    <div class="inline-flex space-x-4 mt-3 lg:mt-0" wire:poll.5s="checkConnectionSession">
                        <span class="text-center text-gray-500">Escaneie o QR Code</span>
                        <button class="text-gray-600 hover:text-gray-800 focus:text-gray-800 cursor-pointer" wire:click="startSession">
                            <x-icon.arrow-path class="w-5 h-5" wire:loading.class="animate-spin" wire:target="startSession" />
                        </button>
                    </div>
                    <img src="{{ $qrcodeInBase64 }}" class="select-none">
                @endif
            @endif

            @if ($connected)

            {{-- MENSAGENS --}}
            <div class="flex flex-col lg:flex-row items-around lg:justify-around w-full mt-3">
                <div class="w-11/12 lg:w-4/12 mb-5 lg:mb-0">
                    <div class=" px-2 py-4 bg-fuchsia-100 min-h-[78vh] rounded-xl shadow-[0_0_5px_rgba(0,0,0,0.3)] shadow-fuchsia-300/70 border border-fuchsia-300 flex flex-col items-center">
                        <h5 class="text-center text-fuchsia-500 text-lg font-semibold">Enviar mensagem para o ganhador</h5>
                        <livewire:whatsapp.send-message>
                    </div>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>