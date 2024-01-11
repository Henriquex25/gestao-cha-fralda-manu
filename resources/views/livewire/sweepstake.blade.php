<div class="flex flex-col items-center justify-center p-0 m-0 space-y-3 lg:space-y-0 lg:items-stretch lg:flex-row">
    <div class="w-9/12 bg-white shadow rounded-lg border border-fuchsia-300/50">
        <h4 class="text-center text-gray-700 text-3xl mb-2 mt-3 font-semibold">Participantes</h4>

        <div class="py-5 px-8">
            {{-- LISTA DE PARTICIPANTES --}}
            <div class="grid grid-cols-4 grid-rows-[repeat(25,_minmax(0,_1fr))] grid-flow-col">
            @foreach($numbers as $number)
                <div>
                    <span class="text-gray-600 font-semibold">{{ $number->id }}</span>
                    -
                    <span class="text-gray-800">{{ $number->payment?->participant->name }}</span>
                </div>
            @endforeach
            </div>
        </div>


    </div>
</div>
