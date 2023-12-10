<?php

namespace App\Livewire;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Number;
use App\Models\Participant;
use App\Models\Payment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PaymentCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->extraAttributes(['style' => 'gap: 1.25rem !important'])
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->default('teste')
                    ->required(),

                TextInput::make('mobile')
                    ->label('Celular')
                    ->mask('(99) 99999-9999')
                    ->default('(11) 99999-9999')
                    ->required(),

                Select::make('payment_type')
                    ->label('Tipo de pagamento')
                    ->default(PaymentType::PIX)
                    ->options(PaymentType::class)
                    ->selectablePlaceholder(false)
                    ->required(),

                Select::make('numbers')
                    ->label('Números')
                    ->multiple()
                    ->options(Number::query()->available()->get()->pluck('id', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('status')
                    ->options(PaymentStatus::class)
                    ->default(PaymentStatus::PENDING)
                    ->selectablePlaceholder(false)
                    ->label('Status')
                    ->required(),

                TextInput::make('observation')
                    ->label('Observação')
                    ->nullable(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        try {
            $chosenNumbers = $this->getChosenNumbers();

            if ($this->chosenNumberIsNotAvailable($chosenNumbers)) {
                Notification::make()
                    ->danger()
                    ->title('Os número(s) escolhido(s) já está(ão) em uso!')
                    ->send();

                return;
            }

            DB::beginTransaction();

            $newParticipant = $this->createParticipant();

            $newPayment = $newParticipant->payments()->create([
                'payment_type' => Arr::get($this->form->getState(), 'payment_type'),
                'observation'  => Arr::get($this->form->getState(), 'observation'),
                'status'       => Arr::get($this->form->getState(), 'status'),
            ]);

            $this->associateParticipant($chosenNumbers, $newPayment);

            DB::commit();

            $this->resetForm();

            $this->dispatch('list::refresh');

            Notification::make()
                ->success()
                ->title('Número(s) rifado(s) com sucesso!')
                ->send();
        } catch (\Exception $e) {
            DB::rollBack();

            Notification::make()
                ->danger()
                ->title($e->getMessage())
                ->send();
        }
    }

    protected function getChosenNumbers(): Collection
    {
        $chosenNumbers = Arr::get($this->form->getState(), 'numbers');

        return Number::query()->whereIn('id', $chosenNumbers)->get();
    }

    protected function chosenNumberIsNotAvailable(Collection $chosenNumbers): bool
    {
        return $chosenNumbers->some(fn (Number $number) => $number->isNotAvailable());
    }

    protected function createParticipant(): Participant
    {
        $participantData = Arr::only($this->form->getState(), ['name', 'mobile']);

        return Participant::query()->updateOrCreate(['name' => $participantData['name']], $participantData);
    }

    protected function associateParticipant(Collection $numbers, Payment $payment): void
    {
        $numbers->each->update(['payment_id' => $payment->id]);
    }

    protected function resetForm(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.payment-create');
    }
}
