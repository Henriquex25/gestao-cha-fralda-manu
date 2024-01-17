<form wire:submit="sendMessage" class="w-full 2xl:w-auto">
    <div class="flex flex-col items-center">
        {{-- NOME + CELULAR --}}
        <div class="flex flex-col 2xl:flex-row items-center 2xl:items-start lg:justify-between w-full px-3 mt-2 text-md text-fuchsia-500">
            <div>
                <span class="text-fuchsia-400">Nome:</span>
                <span class="font-semibold">{{ $winner?->participant->name }}</span>
            </div>
            <div>
                <span class="text-fuchsia-400">Celular:</span>
                <span class="font-semibold">{{ $winner?->participant->mobile }}</span>
            </div>
        </div>

        {{-- MENSAGEM --}}
        <textarea
            class="mt-3.5 px-2 py-1 rounded-xl border-fuchsia-300 focus:ring focus:ring-fuchsia-500/40 focus:border-fuchsia-300 text-fuchsia-500 h-[28rem] w-11/12 focus:outline-none"
            wire:model="message"
        ></textarea>
        @error('message')<span class="text-red-500 mt-0.5">{{ $message }}</span>@enderror

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
