<div class="px-3 py-5 bg-white shadow rounded-xl">

    {{-- PAINEL --}}
    <div class="flex justify-between flex-row mb-3.5">
        <div>
            <span class="text-fuchsia-600">Disponíveis:</span>
            <span class="text-lg font-semibold text-fuchsia-600">{{ $this->getTotalAvailableNumbers() }}</span>
        </div>
        <div>
            <span class="text-fuchsia-600">Pendentes:</span>
            <span
                class="text-lg font-semibold text-fuchsia-600">{{ $this->getTotalUnavailableNumbersWithPendingPayment() }}</span>
        </div>
        <div>
            <span class="text-fuchsia-600">Confirmados:</span>
            <span
                class="text-lg font-semibold text-fuchsia-600">{{ $this->getTotalUnavailableNumbersWithConfirmedPayment() }}</span>
        </div>
    </div>

    <div class="grid grid-cols-10 gap-1">
        {{-- NÚMEROS --}}
        @foreach ($this->numbers as $number)
            <div
                @class([
                    'py-2.5 text-center border',
                    'bg-fuchsia-50 text-fuchsia-500 border-fuchsia-300' => $number->isAvailable(),
                    'bg-fuchsia-200 text-fuchsia-400 border-fuchsia-400' =>
                        $number->isNotAvailable() && $number->payment->isPending(),
                    'bg-fuchsia-400 text-white border-fuchsia-500' =>
                        $number->isNotAvailable() && $number->payment->isPaid(),
                ])
            >{{ $number->id }}</div>
        @endforeach
    </div>
</div>
