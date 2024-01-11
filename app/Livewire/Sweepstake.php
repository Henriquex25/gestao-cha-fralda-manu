<?php

namespace App\Livewire;

use App\Enums\PaymentStatus;
use App\Models\Number;
use Illuminate\Database\Query\JoinClause;
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
        $this->numbers->each(function (Number $number) {
            if (!$this->isValidNumber($number)) {
                return;
            }

            $numberId = $number->id;
            $participantName = $number->payment->participant->name;

            $this->stream('winner', "{$numberId} - {$participantName}", true);
            usleep(50000);
        });

        $validNumbers = $this->numbers->filter(fn (Number $number) => $this->isValidNumber($number));

        $this->winner = $validNumbers->random();

        $this->js("addConfetti()");

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
