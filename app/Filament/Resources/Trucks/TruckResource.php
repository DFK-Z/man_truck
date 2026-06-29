<?php

namespace App\Filament\Resources\Trucks;

use App\Models\Truck;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Грузовики';

    // ✅ ИСПОЛЬЗУЕМ form() С ПРАВИЛЬНЫМИ ИМПОРТАМИ
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')
                    ->columns(2)
                    ->schema([
                        TextInput::make('brand')
                            ->required()
                            ->label('Марка')
                            ->placeholder('Например: MAN, Volvo, Scania'),
                        TextInput::make('model')
                            ->required()
                            ->label('Модель')
                            ->placeholder('Например: TGS, FH, R-Series'),
                        TextInput::make('year')
                            ->required()
                            ->numeric()
                            ->label('Год выпуска')
                            ->placeholder('Например: 2020'),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('₽')
                            ->label('Цена')
                            ->placeholder('Например: 5000000'),
                    ]),
                Section::make('Технические характеристики')
                    ->columns(2)
                    ->schema([
                        TextInput::make('engine')
                            ->label('Двигатель')
                            ->placeholder('Например: 12.5л, 450 л.с.'),
                        TextInput::make('transmission')
                            ->label('Трансмиссия')
                            ->placeholder('Например: Механика, 6 ступеней'),
                        TextInput::make('mileage')
                            ->numeric()
                            ->suffix('км')
                            ->label('Пробег')
                            ->placeholder('Например: 150000'),
                    ]),
                Section::make('Фото и описание')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('trucks')
                            ->label('Фото грузовика')
                            ->helperText('Загрузите фото грузовика (макс. 2MB)'),
                        Textarea::make('description')
                            ->required()
                            ->rows(5)
                            ->label('Описание')
                            ->placeholder('Опишите грузовик: состояние, особенности, комплектация...'),
                    ]),
                Section::make('Статус')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_available')
                            ->default(true)
                            ->label('В наличии'),
                        TextInput::make('views')
                            ->default(0)
                            ->disabled()
                            ->label('Просмотры'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Фото')
                    ->square()
                    ->size(60),
                TextColumn::make('brand')
                    ->label('Марка')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('model')
                    ->label('Модель')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Год')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Цена')
                    ->sortable(),
                IconColumn::make('is_available')
                    ->label('В наличии')
                    ->boolean(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Trucks\Pages\ListTrucks::route('/'),
            'create' => \App\Filament\Resources\Trucks\Pages\CreateTruck::route('/create'),
            'edit' => \App\Filament\Resources\Trucks\Pages\EditTruck::route('/{record}/edit'),
        ];
    }
}
