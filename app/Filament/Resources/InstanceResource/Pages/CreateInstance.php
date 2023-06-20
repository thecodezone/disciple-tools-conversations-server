<?php

namespace App\Filament\Resources\InstanceResource\Pages;

use App\Filament\Resources\InstanceResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateInstance extends CreateRecord
{
    protected static string $resource = InstanceResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                          ->default('Disciple.Tools')
                          ->required()
                          ->helperText('Name your Disciple.Tools instance. For example, Disciple.Tools.')
                          ->maxLength(255),
                TextInput::make('endpoint')
                         ->required()
                         ->helperText('The URL of the Disciple.Tools instance. For example, https://demo.disciple.tools/.')
                         ->maxLength(255),
            ]);
    }
}
