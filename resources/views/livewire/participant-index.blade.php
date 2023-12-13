<div class="flex flex-col items-center h-screen p-0 m-0 space-y-3 lg:space-y-0 lg:items-stretch lg:flex-row">

    {{-- FORMULÁRIO E LISTA --}}
    <div class="order-2 w-full mt-3 lg:mt-0 lg:h-full lg:w-9/12 lg:order-1 lg:pr-5">
        <div class="flex flex-col items-center w-full lg:items-end lg:w-9/12 lg:ml-auto">

            <div class="w-11/12 px-3 py-5 bg-white border shadow rounded-xl border-fuchsia-300/40">
                <livewire:payment-create />
            </div>

            <div class="w-11/12 mt-5 shadow rounded-xl">
                {{ $this->table }}
            </div>
        </div>
    </div>

    {{-- NÚMEROS SORTEADOS --}}
    <div class="order-1 w-11/12 lg:w-[21%] lg:order-2">
        <livewire:number-panel />
    </div>

</div>
