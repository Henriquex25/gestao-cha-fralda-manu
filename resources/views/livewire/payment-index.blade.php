<div class="flex w-screen h-screen p-0 m-0 flew-row">

    {{-- FORMULÁRIO E LISTA --}}
    <div class="w-8/12 h-full">
        <div class="w-9/12 ml-auto pr-14">

            <div class="px-3 py-5 bg-white border shadow rounded-xl border-fuchsia-300/40">
                <livewire:payment-create />
            </div>

            <div class="mt-5 shadow rounded-xl">
                {{ $this->table }}
            </div>
        </div>
    </div>

    {{-- NÚMEROS SORTEADOS --}}
    <div class="w-3/12">
        <livewire:numbers-listing />
    </div>
</div>
