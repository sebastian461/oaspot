<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityResource extends Resource
{
  protected static ?string $model = City::class;

  protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

  protected static ?string $navigationLabel = 'Ciudad';

  protected static ?string $modelLabel = 'Ciudades';

  protected static ?string $navigationGroup = 'Gestión de paises y ciudades';

  protected static ?int $navigationSort = 2;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('country_id')
          ->relationship('country', 'name')
          ->required()
          ->label('País'),
        Forms\Components\TextInput::make('name')
          ->required()
          ->maxLength(255)
          ->label('Ciudad'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('country.name')
          ->numeric()
          ->sortable()
          ->label('País'),
        Tables\Columns\TextColumn::make('name')
          ->searchable()
          ->label('Ciudad'),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListCities::route('/'),
      'create' => Pages\CreateCity::route('/create'),
      'edit' => Pages\EditCity::route('/{record}/edit'),
    ];
  }
}
