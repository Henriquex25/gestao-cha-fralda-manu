<?php

namespace App\Livewire;

use App\Models\Number;
use Illuminate\Support\Collection;
use Livewire\Component;

class NumbersListing extends Component
{
    public Collection $numbers;
    protected $listeners = ['list::refresh' => 'getAllNumbers'];

    public function mount(): void
    {
        $this->getAllNumbers();
    }

    public function getAllNumbers(): void
    {
        $this->numbers = Number::query()
            ->with('payment')
            ->orderBy('id')
            ->get();
    }

    public function getTotalAvailableNumbers(): int
    {
        $availableNumbers = $this->numbers->filter(fn ($number) => $number->isAvailable());

        return $availableNumbers->count();
    }

    public function getTotalUnavailableNumbersWithPendingPayment(): int
    {
        $unavailableNumbers = $this->numbers->filter(fn ($number) => $number->isNotAvailable() && $number->payment->isPending());

        return $unavailableNumbers->count();
    }

    public function getTotalUnavailableNumbersWithConfirmedPayment(): int
    {
        $unavailableNumbers = $this->numbers->filter(fn ($number) => $number->isNotAvailable() && $number->payment->isPaid());

        return $unavailableNumbers->count();
    }

    public function render()
    {
        return view('livewire.numbers-listing');
    }
}
