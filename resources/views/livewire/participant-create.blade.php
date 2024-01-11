<div>
    <form wire:submit="create">
        {{ $this->form }}

        <div class="flex justify-between">
            <div class="flex justify-start space-x-2">
                <button
                    class="px-4 py-2 mt-5 font-semibold text-emerald-500 border border-emerald-500 rounded-3xl bg-transparent hover:bg-emerald-500 hover:text-white focus:bg-emerald-500 focus:text-white focus-visible:outline-emerald-500/70"
                    type="button"
                    x-on:click="window.location.href = '{{ route('sweepstake') }}'"
                >
                    Sorteio
                </button>
            </div>

            <div class="flex justify-end space-x-2">
                <button
                    class="px-4 py-2 mt-5 font-semibold text-white border rounded-3xl bg-gray-400 hover:scale-105 hover:bg-gray-500 focus:scale-105 focus:bg-gray-500 focus-visible:outline-gray-700/70"
                    type="button"
                    wire:click="resetForm"
                >
                    Limpar
                </button>
                <button
                    class="px-4 py-2 mt-5 font-semibold text-white border rounded-3xl bg-fuchsia-500 hover:scale-105 hover:bg-fuchsia-600 focus:scale-105 focus:bg-fuchsia-600 focus-visible:outline-fuchsia-800/70"
                    type="submit"
                >
                    Criar
                </button>
            </div>
        </div>
    </form>
</div>
