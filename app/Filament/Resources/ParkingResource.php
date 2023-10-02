<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParkingResource\Pages;
use App\Filament\Resources\ParkingResource\RelationManagers;
use App\Models\Parking;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Filament\Forms\Components\Hidden;

class ParkingResource extends Resource
{
  protected static ?string $model = Parking::class;

  protected static ?string $navigationIcon = 'heroicon-o-truck';

  protected static ?string $navigationLabel = 'Parqueadero';

  protected static ?string $modelLabel = 'Parqueaderos';

  protected static ?string $navigationGroup = 'Gestión de parqueaderos';

  protected static ?int $navigationSort = 1;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        //
        TextInput::make('name')->required()->label('Nombre'),
        Hidden::make('user_id')->default(auth()->id()),
        Select::make('city_id')->relationship('city', 'name')->required()->label('Ciudad'),
        TextInput::make('address')->required()->label('Dirección'),
        TextInput::make('places')->numeric()->required()->label('Plazas'),
        TextInput::make('price')->numeric()->required()->label('Precio'),
        Textarea::make('description')->label('Descripción')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        //
        TextColumn::make('name')->label('Nombre'),
        TextColumn::make('city.name')->label('Ciudad'),
        TextColumn::make('address')->label('Dirección'),
        TextColumn::make('places')->label('Plazas'),
        TextColumn::make('price')->label('Precio'),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions(
        [
          Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make(),
          ]),
        ]
      )
      ->modifyQueryUsing(function (Builder $query) {
        if (auth()->user()->hasRole(['User'])) {
          $query->where('user_id', auth()->id());
        }
      });
  }

  public static function getRelations(): array
  {
    return [
      //
      RelationManagers\DocumentsRelationManager::class,
      RelationManagers\ImageRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListParkings::route('/'),
      'create' => Pages\CreateParking::route('/create'),
      'edit' => Pages\EditParking::route('/{record}/edit'),
    ];
  }
}
