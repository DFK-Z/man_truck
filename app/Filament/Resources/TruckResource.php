<?php

namespace App\Filament\Resources;

use App\Models\Truck;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Грузовики';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('brand')->required()->label('Марка'),
            TextInput::make('model')->required()->label('Модель'),
            TextInput::make('year')->required()->numeric()->label('Год'),
            TextInput::make('price')->required()->numeric()->label('Цена'),
            Textarea::make('description')->required()->rows(5)->label('Описание'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand')->label('Марка')->searchable(),
                TextColumn::make('model')->label('Модель')->searchable(),
                TextColumn::make('year')->label('Год'),
                TextColumn::make('price')->label('Цена'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\TruckResource\Pages\ListTrucks::route('/'),
            'create' => \App\Filament\Resources\TruckResource\Pages\CreateTruck::route('/create'),
            'edit' => \App\Filament\Resources\TruckResource\Pages\EditTruck::route('/{record}/edit'),
        ];
    }
}
