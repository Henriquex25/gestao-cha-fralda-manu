<?php

namespace App\Livewire;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ParticipantIndex extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public ?array $data = [];

    protected $listeners = ['list::refresh' => '$refresh'];

    public function table(Table $table): Table
    {
        return $table
            ->query(Payment::query()->with(['participant', 'numbers']))
            ->columns([
                TextColumn::make('participant.name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('participant.mobile')
                    ->label('Celular')
                    ->searchable(),

                TextColumn::make('payment_type')
                    ->label('Fralda ou pix'),

                TextColumn::make('numbers.id')
                    ->label('Números'),

                IconColumn::make('status')
                    ->label('Pagamento'),

                TextColumn::make('observation')
                    ->label('Observação'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->date('d/m/Y H:i'),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Pagamento')
                    ->options([
                        'pendente' => 'Pendente',
                        'pago'     => 'Pago',
                    ]),

                SelectFilter::make('payment_type')
                    ->label('Pix ou Fralda')
                    ->options([
                        'pix'    => 'Pix',
                        'fralda' => 'Fralda',
                    ])
            ])
            ->actions([
                Action::make('Confirmar pagamento')
                    ->label('Confirmar pag.')
                    ->icon('heroicon-o-check')
                    ->button()
                    ->color('success')
                    ->size(ActionSize::Small)
                    ->outlined()
                    ->visible(fn (Model $payment) => $payment->isPending())
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar pagamento')
                    ->modalDescription('Tem certeza que deseja confirmar o pagamento?')
                    ->action(function (Model $payment) {
                        $payment->update(['status' => PaymentStatus::PAID]);
                        Notification::make()
                            ->title('Pagamento confirmado com sucesso')
                            ->success()
                            ->send();

                        $this->dispatch('list::refresh');
                    }),
                Action::make('Remover participante')
                    ->label('Remover')
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger')
                    ->size(ActionSize::Small)
                    ->outlined()
                    ->visible(fn (Model $payment) => !$payment->isPaid())
                    ->requiresConfirmation()
                    ->modalHeading('Remover participante')
                    ->modalDescription('Tem certeza que deseja remover o participante?')
                    ->action(function (Model $payment) {
                        $payment->delete();

                        Notification::make()
                            ->title('Participante removido com sucesso')
                            ->success()
                            ->send();

                        $this->dispatch('list::refresh');
                    }),

            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.participant-index');
    }
}
