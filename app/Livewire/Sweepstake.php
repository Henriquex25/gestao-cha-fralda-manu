<?php

namespace App\Livewire;

use App\Models\Number;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Livewire\Component;

class Sweepstake extends Component
{
    public Collection $numbers;

    public function mount(): void
    {
        $this->getAllNumbers();
    }

    public function getAllNumbers(): void
    {
        $this->numbers = Number::query()
            ->with('payment.participant')
            ->orderBy('id')
            ->get();
    }

    public function render()
    {
        return view('livewire.sweepstake');
    }
}
