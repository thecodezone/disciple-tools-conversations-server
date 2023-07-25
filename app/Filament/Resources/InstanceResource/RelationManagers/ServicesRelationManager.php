<?php

namespace App\Filament\Resources\InstanceResource\RelationManagers;

use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                                          ->required()
                                          ->maxLength(255),
                Forms\Components\Select::make('type')
                                       ->relationship('type', 'name')
                                       ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('connected')
                          ->options([
                              'heroicon-s-lightning-bolt',
                              'heroicon-s-exclamation' => fn ($state, $record): bool => !$record->connected,
                              'heroicon-s-lightning-bolt' => fn ($state, $record): bool => $record->connected
                          ]),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('type.name'),
                Tables\Columns\TextColumn::make('instance.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->after(function ($livewire) {
                    $livewire->emit('refresh');
                }),
            ])
            ->actions([
                Action::make('connect')
                      ->hidden(fn ($record): bool => !$record->type)
                      ->url(function (Service $record): string {
                          return route('services.oauth.redirect', $record);
                      })
                      ->icon('heroicon-s-lightning-bolt'),
                Tables\Actions\EditAction::make()->after(function ($livewire) {
                    $livewire->emit('refresh');
                }),
                Tables\Actions\DeleteAction::make()->after(function ($livewire) {
                    $livewire->emit('refresh');
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
