<?php

namespace App\Livewire;

use App\Models\Payment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PaymentIndex extends Component implements HasForms, HasTable
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
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.payment-index');
    }
}
