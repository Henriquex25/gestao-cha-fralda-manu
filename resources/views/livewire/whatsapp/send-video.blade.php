<form wire:submit="sendVideo" class="w-full lg:w-auto">
    <div x-data class="flex flex-col items-center">
        <input
            type="file"
            class="text-fuchsia-500 w-11/12 2xl:w-auto"
            wire:model="uploadedVideo"
            accept="video/mp4"
            x-on:change="$refs.sendVideoButton.disabled = $el.value ? false : true"
        >
        @error('uploadedVideo') <span class="mt-0.5 text-red-500">{{ $message }}</span> @enderror

        {{-- MENSAGEM --}}
        <textarea
            class="mt-4 px-2 py-1 lg:mt-3.5 rounded-xl border-fuchsia-300 focus:ring focus:ring-fuchsia-500/40 focus:border-fuchsia-300 text-fuchsia-500 h-[26.66rem] w-11/12 focus:outline-none"
            wire:model="message"
        ></textarea>
        @error('message')<span class="text-red-500 mt-0.5">{{ $message }}</span>@enderror

        <button
            class="px-4 py-2 mt-6 font-semibold text-white border rounded-3xl bg-fuchsia-500 hover:bg-fuchsia-600 focus:bg-fuchsia-600 focus-visible:outline-fuchsia-800/70
            flex items-center justify-center disabled:bg-fuchsia-400/75"
            type="submit"
            wire:loading.attr="disabled"
            wire:loading.class="disabled:cursor-wait"
            wire:target="sendVideo"
            wire:confirm="Deseja realmente enviar o vídeo para todos os participantes?"
            x-ref="sendVideoButton"
        >
            <x-loading wire:loading wire:target="sendVideo" class="text- h-5 w-5 mr-2" />
            Enviar
        </button>
    </div>
</form>
