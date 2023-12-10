<div>
    <form wire:submit="create">
        {{ $this->form }}

        <div class="flex justify-end">
            <button
                class="px-4 py-2 mt-5 font-semibold text-white border rounded-3xl bg-fuchsia-500 hover:scale-105 hover:bg-fuchsia-600 focus:scale-105 focus:bg-fuchsia-600 focus-visible:outline-fuchsia-800/70"
                type="submit"
            >
                Criar
            </button>
        </div>
    </form>
</div>
