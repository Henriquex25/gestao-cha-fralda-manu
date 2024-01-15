<form wire:submit="sendMessage">
    <div class="flex flex-col items-center">
        {{-- NOME + CELULAR --}}
        <div class="flex flex-row justify-between w-full px-3 mt-2 text-md text-fuchsia-500">
            {{-- <div>
                <span>Nome:</span>
                <span>{{ $winner?->name }}</span>
            </div> --}}
            <div>
                <span>Celular:</span>
                {{-- <span>{{ $winner?->mobile }}</span> --}}
                <span>
                    <input type="text" wire:model="winnerPhone" class="rounded-2xl ml-1 h-7 text-fuchsia-500 bg-white border border-fuchsia-400 focus:border-fuchsia-500 focus:ring-fuchsia-500">
                    @error('winnerPhone')<span class="text-red-500 mt-0.5">{{ $message }}</span>@enderror
                </span>
            </div>
        </div>

        {{-- MENSAGEM --}}
        <textarea
            class="mt-3.5 rounded-xl border-fuchsia-300 focus:ring focus:ring-fuchsia-500/40 focus:border-fuchsia-300 text-fuchsia-500"
            cols="40"
            rows="20"
            wire:model="messageToWinner"
        ></textarea>
        @error('messageToWinner')<span class="text-red-500 mt-0.5">{{ $message }}</span>@enderror

        {{-- BOTAO ENVIAR --}}
        <button
            class="px-4 py-2 mt-5 font-semibold text-white border rounded-3xl bg-fuchsia-500 hover:bg-fuchsia-600 focus:bg-fuchsia-600 focus-visible:outline-fuchsia-800/70
            flex items-center justify-center disabled:bg-fuchsia-400/75"
            type="submit"
            wire:loading.attr="disabled"
            wire:loading.class="disabled:cursor-wait"
            wire:target="sendMessage"
            wire:confirm="Deseja realmente enviar esta mensagem?"
        >
            <x-loading wire:loading wire:target="sendMessage" class="text- h-5 w-5 mr-2" />
            Enviar
        </button>
    </div>
</form>
