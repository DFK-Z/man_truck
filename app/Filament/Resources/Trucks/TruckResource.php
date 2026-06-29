<?php

namespace App\Filament\Resources\Trucks;

use App\Filament\Resources\Trucks\TruckResource\Pages;
use App\Models\Truck;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;

    // УБИРАЕМ ?string - оставляем просто свойство
    protected static $navigationIcon = 'heroicon-o-truck';

    protected static $navigationLabel = 'Грузовики';

    protected static $modelLabel = 'Грузовик';

    protected static $pluralModelLabel = 'Грузовики';

    // Добавляем сортировку в меню
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')
                    ->columns(2)
                    ->schema([
                        TextInput::make('brand')
                            ->label('Марка')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: MAN, Volvo, Scania')
                            ->columnSpan(1),

                        TextInput::make('model')
                            ->label('Модель')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Например: TGS, FH, R-Series')
                            ->columnSpan(1),

                        TextInput::make('year')
                            ->label('Год выпуска')
                            ->required()
                            ->numeric()
                            ->minValue(1990)
                            ->maxValue(date('Y'))
                            ->placeholder('Например: 2020')
                            ->columnSpan(1),

                        TextInput::make('price')
                            ->label('Цена (₽)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->placeholder('Например: 5000000')
                            ->prefix('₽')
                            ->columnSpan(1),
                    ]),

                Section::make('Технические характеристики')
                    ->columns(2)
                    ->schema([
                        TextInput::make('engine')
                            ->label('Двигатель')
                            ->placeholder('Например: 12.5л, 450 л.с.')
                            ->columnSpan(1),

                        TextInput::make('transmission')
                            ->label('Трансмиссия')
                            ->placeholder('Например: Механика, 6 ступеней')
                            ->columnSpan(1),

                        TextInput::make('mileage')
                            ->label('Пробег (км)')
                            ->numeric()
                            ->placeholder('Например: 150000')
                            ->suffix('км')
                            ->columnSpan(1),
                    ]),

                Section::make('Фото и описание')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Изображение грузовика')
                            ->image()
                            ->directory('trucks')
                            ->maxSize(2048)
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('600')
                            ->helperText('Загрузите фото грузовика (макс. 2MB)')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Описание')
                            ->rows(5)
                            ->required()
                            ->placeholder('Опишите грузовик: состояние, особенности, комплектация...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Статус')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_available')
                            ->label('В наличии')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpan(1),

                        TextInput::make('views')
                            ->label('Просмотры')
                            ->default(0)
                            ->disabled()
                            ->numeric()
                            ->columnSpan(1),
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
                    ->size(60)
                    ->defaultImageUrl('/images/no-image.png'),

                TextColumn::make('brand')
                    ->label('Марка')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('model')
                    ->label('Модель')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('year')
                    ->label('Год')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('formatted_price')
                    ->label('Цена')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('success'),

                IconColumn::make('is_available')
                    ->label('В наличии')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('views')
                    ->label('👁 Просмотры')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('created_at')
                    ->label('Добавлен')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('brand')
                    ->label('Фильтр по марке')
                    ->options(
                        Truck::distinct()->pluck('brand', 'brand')->toArray()
                    )
                    ->placeholder('Все марки'),

                TernaryFilter::make('is_available')
                    ->label('В наличии')
                    ->placeholder('Все')
                    ->trueLabel('Только в наличии')
                    ->falseLabel('Нет в наличии'),

                Filter::make('price_range')
                    ->label('Цена')
                    ->form([
                        TextInput::make('price_from')
                            ->label('Цена от')
                            ->numeric()
                            ->placeholder('0'),
                        TextInput::make('price_to')
                            ->label('Цена до')
                            ->numeric()
                            ->placeholder('1000000'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['price_from'], fn($q) => $q->where('price', '>=', $data['price_from']))
                            ->when($data['price_to'], fn($q) => $q->where('price', '<=', $data['price_to']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Просмотр'),
                Tables\Actions\EditAction::make()
                    ->label('Редактировать')
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->label('Удалить')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Удалить выбранные'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrucks::route('/'),
            'create' => Pages\CreateTruck::route('/create'),
            'edit' => Pages\EditTruck::route('/{record}/edit'),
            'view' => Pages\ViewTruck::route('/{record}'),
        ];
    }
}
