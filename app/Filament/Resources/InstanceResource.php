<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstanceResource\Pages;
use App\Filament\Resources\InstanceResource\RelationManagers;
use App\Models\Instance;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class InstanceResource extends Resource
{
    public function reload()
    {
        $this->refresh();
    }

    protected static ?string $model = Instance::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('endpoint')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('verification_token')->helperText(
                    'This token is used to verify requests are safe. Add it to your DT conversations plugin options in WordPress.'
                )->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('endpoint'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('Connections', [
                RelationManagers\ServicesRelationManager::class,
                RelationManagers\ChannelsRelationManager::class,
            ]),
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstances::route('/'),
            'create' => Pages\CreateInstance::route('/create'),
            'edit' => Pages\EditInstance::route('/{record}/edit'),
        ];
    }
}
