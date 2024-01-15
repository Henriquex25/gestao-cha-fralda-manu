@use('App\Enums\PaymentStatus')

<div
    x-data="sweepstake"
    class="flex flex-col items-center justify-center p-0 m-0 space-y-3 lg:space-y-0 lg:items-stretch lg:flex-row"
>

    <div class="w-9/12 bg-white relative shadow rounded-xl border border-fuchsia-300/50 relative">
        <button
            class="absolute right-6 -top-8 bg-transparent z-20 text-fuchsia-500 hover:text-fuchsia-600 focus:text-fuchsia-600"
            x-on:click="window.location.href = '{{ route('index') }}'"
        >
            Voltar
        </button>

        {{-- CONFETE --}}
        @if(!is_null($winner))
            <canvas id="canvas" class="absolute left-0 top-0 w-full h-full" width="100%" height="100%"></canvas>
        @endif

        <div class="flex items-center mb-3.5 mt-5 flex-col">

            {{-- BOTÃO DE INICIAR CONTAGEM REGRESSIVA --}}
            <button
                type="button"
                class="w-60 h-14 bg-fuchsia-600 text-white rounded-3xl font-semibold text-2xl leading-9 disabled:bg-fuchsia-500/80 disabled:cursor-wait"
                x-on:click="startCountdown"
                x-ref="startCountdownButton"
                x-show="!showSweepstake"
            >
                Iniciar sorteio
            </button>

            <div
                x-show="showSweepstake"
                wire:stream="winner"
                @class([
                    "font-bold text-white bg-fuchsia-600 text-5xl w-full  flex flex-col items-center justify-center",
                    "h-20" => is_null($winner),
                    "h-[6.7rem]" => !is_null($winner),
                ])
                x-cloak
            >
                <span class="text-lg flex flex-row select-none">O vencedor foi</span>
                <div class="flex flex-row items-center justify-center mt-0.5">
                    <x-icon.trophy class="!h-10 !w-10 mt-1.5 select-none" />
                    <span class="mx-3">{{ !is_null($winner) ? "{$winner->id} - {$winner->payment->participant->name}" : '' }}</span>
                    <x-icon.trophy class="!h-10 !w-10 mt-1.5 select-none" />
                </div>
            </div>

        </div>

        <h4 class="text-center text-gray-600 text-3xl mb-2 mt-3 font-bold">Participantes</h4>

        <div class="py-5 px-8">
            {{-- LISTA DE PARTICIPANTES --}}
            <div class="grid grid-cols-4 grid-rows-[repeat(25,_minmax(0,_1fr))] grid-flow-col">
            @foreach($numbers->sortBy('id') as $number)
                <div>
                    <span
                        @class([
                            "font-semibold",
                            "text-gray-600" => $this->isValidNumber($number),
                            "text-red-500" => !$this->isValidNumber($number),
                        ])
                    >{{ $number->id }}</span>
                    -
                    <span
                        @class([
                            "text-gray-800" => $this->isValidNumber($number),
                            "text-red-500" => !$this->isValidNumber($number),
                        ])
                    >{{ $this->isValidNumber($number) ? $number->payment->participant->name : 'Disponível ou não confirmado' }}</span>
                </div>
            @endforeach
            </div>
        </div>


    </div>
</div>

@script
@push('scripts')
    @vite('resources/js/confetti.js')
@endpush
<script>
    Alpine.data('sweepstake', () => {
        return {
            showSweepstake: false,
            countTo: 3,
            countdown: null,
            init() {
                this.countdown = this.countTo;

            },
            startCountdown() {
                const countdown = setInterval(() => {
                    const button = this.$refs.startCountdownButton;

                    button.disabled = true;
                    button.innerText = this.countdown;

                    this.countdown--;

                    if (this.countdown <= 0) {
                        clearInterval(countdown);
                        setTimeout(() => this.$nextTick(() => {
                            this.showSweepstake = true;
                            this.$wire.sweepstake();
                        }), 1000)
                    }
                }, 1000)

            },
            addConfetti() {
                this.$nextTick(() => {
                    const canvas = document.getElementById('canvas')

                    const confetti = new JSConfetti({ canvas })

                    let count = 3;

                    const interval = setInterval(() => {
                        confetti.addConfetti();
                        count--;

                        if(count < 0) {
                            clearInterval(interval)
                        }
                    }, 800);
                })
            },
        }
    })
</script>
@endscript
