<?php

namespace App\Filament\Resources\InstanceResource\RelationManagers;

use App\Models\ChannelType;
use App\Models\Service;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

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
                    ->relationship('type', 'label')
                    ->required(),
                Forms\Components\Select::make('service')
                    ->reactive()
                    ->relationship('service', 'name')
                    ->required(),
                Forms\Components\Repeater::make('settings')
                    ->hidden(function ($get) {
                        return count(self::getSettingsFields($get)) < 1;
                    })
                    ->required(function ($get) {
                        return count(self::getSettingsFields($get)) > 0;
                    })
                    ->schema(function ($get) {
                        return self::getSettingsFields($get);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                    ->hidden(fn ($record): bool => ! $record->type)
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

    /**
     * Derive the settings fields from $get
     *
     * @param $get
     * @return array
     */
    protected static function getSettingsFields($get): array
    {
        $type = $get('type');
        $service = $get('service');

        if (! $type || ! $service) {
            return [];
        }

        $service = Service::find($service);

        if (! $service) {
            return [];
        }

        $config = ChannelType::find($type)->config();

        return app($config['settings'])->fields($service);
    }
}
