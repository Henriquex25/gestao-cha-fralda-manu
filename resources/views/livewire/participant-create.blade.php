<div>
    <form wire:submit="create">
        {{ $this->form }}

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
    </form>
</div>