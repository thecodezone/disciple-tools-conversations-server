<?php

namespace App\Filament\Resources\InstanceResource\RelationManagers;

use App\Channels\Channel;
use App\Models\ChannelType;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use App\Models\Instance;
use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\Livewire;

class ChannelsRelationManager extends RelationManager
{
    protected static string $relationship = 'channels';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->reactive()
                   ->relationship('type', 'name')
                   ->required(),
                Forms\Components\Select::make('service')
                    ->relationship('service', 'name')
                    ->required(),
                Forms\Components\Repeater::make('settings')
                    ->hidden(function($get) {
                        if (!$get('type')) {
                            return true;
                        }
                        $type = ChannelType::find($get('type'));
                        return count($type->driver()->settingsFields()) < 1;
                    })
                    ->required(function($get) {
                        if (!$get('type')) {
                            return false;
                        }
                        $type = ChannelType::find($get('type'));
                        return count($type->driver()->settingsFields()) > 0;
                    })
                    ->schema(function($get) {
                        $type = ChannelType::find($get('type'));
                        if (!$type) {
                            return [];
                        }
                        return ChannelType::find($get('type'))->driver()->settingsFields();
                    })
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
                Tables\Columns\TextColumn::make('service.name'),
                Tables\Columns\TextColumn::make('service.instance.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('connect')
                      ->hidden(fn ($record): bool => !$record->type)
                      ->url(function (Model $record): string {
                          return route('services.oauth.redirect', $record->service);
                      })
                      ->icon('heroicon-s-lightning-bolt'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
