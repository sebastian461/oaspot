<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Models\Image;
use App\Models\Parking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;


class ImageResource extends Resource
{
  protected static ?string $model = Image::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('parking_id')
          ->options(Parking::where('user_id', auth()->id())->pluck('name', 'id'))
          ->required(),
        FileUpload::make('url')
          ->downloadable()
          ->image()
          ->required()
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('parking.name')
          ->numeric()
          ->sortable(),
        Tables\Columns\TextColumn::make('url'),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable(),
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
      ])->modifyQueryUsing(function (Builder $query) {
        if (auth()->user()->hasRole(['User'])) {
          $query->whereHas('parking', function ($query) {
            $query->where('user_id', auth()->id());
          });
        }
      });
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
      'index' => Pages\ListImages::route('/'),
      'create' => Pages\CreateImage::route('/create'),
      'edit' => Pages\EditImage::route('/{record}/edit'),
    ];
  }
}
