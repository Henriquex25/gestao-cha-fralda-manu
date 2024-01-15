<?php

namespace App\Livewire;

use App\Enums\PaymentStatus;
use App\Models\Number;
use App\Models\Winner;
use Illuminate\Support\Collection;
use Livewire\Component;

class Sweepstake extends Component
{
    public Collection $numbers;
    public ?Number $winner = null;

    public function mount(): void
    {
        $this->getAllNumbers();
    }

    protected function getAllNumbers(): void
    {
        $this->numbers = Number::query()
            ->with('payment.participant')
            ->orderBy('id')
            ->get();
    }

    public function sweepstake(): void
    {
        $this->sweepstakeStream();
        $this->sweepstakeStream();

        $validNumbers = $this->numbers->filter(fn (Number $number) => $this->isValidNumber($number));

        $this->winner = $validNumbers->random();

        $this->storeWinner();

        $this->js("addConfetti()");
    }

    protected function storeWinner(): void
    {
        Winner::query()
            ->create([
                'number_id'      => $this->winner->id,
                'participant_id' => $this->winner->payment->participant->id,
            ]);
    }

    protected function sweepstakeStream(): void
    {
        $this->numbers->each(function (Number $number) {
            if (!$this->isValidNumber($number)) {
                return;
            }

            $numberId        = $number->id;
            $participantName = $number->payment->participant->name;

            $this->stream('winner', "{$numberId} - {$participantName}", true);
            usleep(50000);
        });
    }

    public function isValidNumber(Number $number): bool
    {
        return !is_null($number->payment()) && $number->payment?->status === PaymentStatus::PAID;
    }

    public function render()
    {
        return view('livewire.sweepstake');
    }
}
